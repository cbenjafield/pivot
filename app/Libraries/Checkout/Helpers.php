<?php

namespace Benjafield\Checkout;

class Helpers
{

    public static function isHarben()
    {
        return request()->ip() == env('HARBEN_IP');
    }

}