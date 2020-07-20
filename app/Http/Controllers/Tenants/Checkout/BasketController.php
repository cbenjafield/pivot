<?php

namespace App\Http\Controllers\Tenants\Checkout;

use Theme;
use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Basket;

class BasketController extends Controller
{

    public function index()
    {
        $website = request('website');

        return Theme::view('basket', compact('website'));
    }

    public function add(Product $product)
    {
        $site = request('website');

        $item = Basket::add(
            $product->type,
            $product->id,
            $product->name,
            1,
            $product->price,
            $site->tld,
            $product->type
        );

        return response()->json([
            'item' => $item,
        ], 200);
    }
}
