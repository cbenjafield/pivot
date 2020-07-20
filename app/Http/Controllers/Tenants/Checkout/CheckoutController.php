<?php

namespace App\Http\Controllers\Tenants\Checkout;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Checkout;
use Basket;
use Theme;

class CheckoutController extends Controller
{
    public function checkout()
    {
        $website = request('website');

        if(Basket::isEmpty()) {
            return redirect('/basket');
        }

        return Theme::view('checkout', compact('website'));
    }
}
