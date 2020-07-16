<?php

namespace Benjafield\Checkout\Facades;

use Illuminate\Support\Facades\Facade;

class Checkout extends Facade
{
	public static function getFacadeAccessor()
	{
		return 'checkout';
	}
}
