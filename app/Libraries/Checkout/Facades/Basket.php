<?php

namespace Benjafield\Checkout\Facades;

use Illuminate\Support\Facades\Facade;

class Basket extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'basket';
    }
}
