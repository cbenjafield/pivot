<?php

namespace Benjafield\Checkout\PayPal;

use Benjafield\PayPal\Checkout\PayPalClient;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

class CaptureOrder
{

    public static function captureOrder($orderId)
    {
        $request = new OrdersCaptureRequest($orderId);

        $client = PayPalClient::client();
        $response = $client->execute($request);

        return $response;
    }

}
