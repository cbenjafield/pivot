<?php

namespace Benjafield\Checkout\PayPal;

use Benjafield\PayPal\Checkout\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Checkout;
use Basket;

class CreateOrder
{
    public static function createOrder()
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody();

        $client = PayPalClient::client();

        $response = $client->execute($request);

        return $response;
    }

    protected static function buildRequestBody()
    {
        return [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => url('paypal/complete'),
                'cancel_url' => url('step-3?paypal=true&status=cancel'),
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'reference_id' => Checkout::get('transaction_id'),
                    'custom_id' => Checkout::get('transaction_id'),
                    'description' => Basket::description(),
                    'amount' => [
                        'currency_code' => 'GBP',
                        'value' => Basket::total(),
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'GBP',
                                'value' => Basket::total()
                            ]
                        ]
                    ],
                    'items' => Basket::paypalItems(),
                ]
            ]
        ];
    }
}
