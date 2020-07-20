<?php

use Illuminate\Support\Facades\Route;

Route::post('basket/{product}', 'Checkout\BasketController@add');
Route::get('basket', 'Checkout\BasketController@index');
Route::get('checkout', 'Checkout\CheckoutController@checkout');

Route::get('/', 'WebsiteController@index');
Route::post('contact/{form}', 'ContactController@submitForm');

Route::fallback('WebsiteController@article');
