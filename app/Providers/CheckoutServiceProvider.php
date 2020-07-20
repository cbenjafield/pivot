<?php

namespace App\Providers;

use Benjafield\Checkout\Basket;
use Illuminate\Support\ServiceProvider;
use Benjafield\Checkout\Checkout;

class CheckoutServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('checkout', Checkout::class);
        $this->app->bind('basket', Basket::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
