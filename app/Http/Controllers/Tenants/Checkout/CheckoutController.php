<?php

namespace App\Http\Controllers\Tenants\Checkout;

use App\Http\Controllers\Controller;
use App\Wolf\Order;
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

    public function confirmation(Order $order)
    {
        $website = request('website');

        return Theme::view('confirmation', compact('website', 'order'));
    }
}
