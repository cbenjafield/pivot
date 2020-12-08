<?php

namespace Benjafield\Checkout\PayPal;

use Benjafield\PayPal\Checkout\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use Checkout;
use Basket;

class CreateOrder
{
    public static function createOrder($orderId)
    {
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = self::buildRequestBody($orderId);

        $client = PayPalClient::client();

        $response = $client->execute($request);

        return $response;
    }

    protected static function buildRequestBody($orderId)
    {
        return [
            'intent' => 'CAPTURE',
            'application_context' => [
                'return_url' => url('checkout/complete'),
                'cancel_url' => url('/checkout?paypal-status=cancel'),
                'user_action' => 'PAY_NOW',
            ],
            'purchase_units' => [
                [
                    'reference_id' => $orderId,
                    'custom_id' => $orderId,
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
