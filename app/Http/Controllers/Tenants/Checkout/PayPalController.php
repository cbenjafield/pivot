<?php

namespace App\Http\Controllers\Tenants\Checkout;

use App\Http\Controllers\Controller;
use App\Wolf\Order;
use Benjafield\Checkout\PayPal\CreateOrder;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use PayPalHttp\HttpException;
use Basket;
use Benjafield\Checkout\PayPal\CaptureOrder;

class PayPalController extends Controller
{
    /**
     * Create the payment on PayPal.
     * 
     * @return \Illuminate\Http\Response
     */
    public function make()
    {
        $this->validate(request(), $this->validationRules());

        $orderId = Order::makeOrderId();

        session()->put('pp_previous_form_data', collect(request()->all()));

        session()->put('pp_transaction_id', $orderId);

        $order = CreateOrder::createOrder($orderId);

        if(isset($order->result->links)) {
            foreach($order->result->links as $link) {
                if($link->rel == 'approve') {
                    $redirectUrl = $link->href;
                    break;
                }
            }
        }

        if(! isset($redirectUrl)) {
            return response()->json([
                'message' => 'The PayPal order could not be created.'
            ], 400);
        }

        session()->put('pp_order_id', $order->result->id);

        return response()->json([
            'redirect_url' => $redirectUrl,
        ], 201);
    }

    /**
     * The rules validation should follow.
     * 
     * @return array
     */
    protected function validationRules()
    {
        return [
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone' => ['required', 'phone:GB'],
            'pupil_name' => ['required', 'string', 'max:255'],
            'pupil_postcode' => [
                'required',
                Rule::postcode(),
            ],
            'notes' => ['sometimes', 'nullable', 'max:1000'],
        ];
    }

    /**
     * Complete the PayPal payment.
     * 
     * @return \Illuminate\Http\Response
     */
    public function complete()
    {
        $token = request('token');
        $payerId = request('PayerID');
        $orderId = session('pp_order_id');
        $transactionId = session('pp_transaction_id');

        try {
            $capture = CaptureOrder::captureOrder($orderId);
        } catch(HttpException $e) {
            return redirect('/checkout')
                        ->with('previous_input', session('pp_previous_form_data')->toJson())
                        ->with('paypalError', $e->getMessage());
        }

        if($capture->result->status == 'COMPLETED') {
            $order = $this->makeOrder($capture, $transactionId);

            Basket::destroy();

            return redirect('/checkout/confirmation/' . $order->order_id);
        } else {
            return redirect('/checkout')
                        ->with('previous_input', session('pp_previous_form_data')->toJson())
                        ->with('paypalError', 'An error occurred while connecting with PayPal.');
        }
    }


    /**
     * Create the order on Wolf.
     * 
     * @param  mixed   $capture
     * @param  string  $transactionId
     * @return \App\Wolf\Order
     */
    protected function makeOrder($capture, $transactionId)
    {
        $formData = session('pp_previous_form_data')->toArray();

        $order = new Order([
            'order_id' => $transactionId,
            'order_description' => Basket::description(),
            'amount' => Basket::penceTotal(),
            'actual_amount' => Basket::penceTotal(false),
            'billing_phone' => $formData['phone'] ?? $capture->result->payer->phone->phone_number->national_number ?? null,
            'billing_name' => "{$capture->result->payer->name->given_name} {$capture->result->payer->name->surname}",
            'billing_email' => $capture->result->payer->email_address ?? null,
            'billing_address_1' => $capture->result->payer->address->address_line_1 ?? null,
            'billing_postcode' => $capture->result->payer->address->postal_code ?? null,
            'billing_country' => 'United Kingdom',
            'pupil_name' => $formData['pupil_name'] ?? null,
            'items' => Basket::getJsonItems(),
            'pickup_address' => 0, 
            'delivery_address' => 0,
            'gateway' => 'PayPal',
            'paypal' => 1,
            'origin' => request('domain'),
            'cross_reference' => $capture->result->id,
            'payment_successful' => 1,
            'auth_code' => mt_rand(100000, 999999),
            'gift_voucher' => 0,
        ]);

        $order->save();

        return $order;
    }
}
