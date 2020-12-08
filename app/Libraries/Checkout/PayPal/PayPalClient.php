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
        $credentials = request('website')->paypalCredentials();

        return new SandboxEnvironment(
            $credentials['client_id'],
            $credentials['secret']
        );
    }
}