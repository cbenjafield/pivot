<?php

namespace Benjafield\PayPal\Checkout;

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Core\ProductionEnvironment;

class PayPalClient
{
    public static function client()
    {
        return new PayPalHttpClient(self::environment());
    }

    public static function environment()
    {
        $clientId = env('PAYPAL_CLIENT_ID');
        $clientSecret = env('PAYPAL_CLIENT_SECRET');

        return new ProductionEnvironment($clientId, $clientSecret);
    }
}