<?php

use Illuminate\Support\Facades\Route;

Route::post('basket/{product}', 'Checkout\BasketController@add');
Route::get('basket', 'Checkout\BasketController@index');
Route::get('checkout', 'Checkout\CheckoutController@checkout');
Route::put('basket/{item}', 'Checkout\BasketController@update');
Route::delete('basket/{item}', 'Checkout\BasketController@destroy');

Route::post('checkout/pay', 'Checkout\PayPalController@make');
Route::get('checkout/complete', 'Checkout\PayPalController@complete');
Route::get('checkout/confirmation/{order}', 'Checkout\CheckoutController@confirmation');

Route::get('/', 'WebsiteController@index');
Route::post('contact/{form}', 'ContactController@submitForm');

Route::get('sitemap', 'SitemapController@index')->name('sitemap');
Route::get('xml-sitemap', 'SitemapController@xml');
Route::get('xml-sitemap/pages', 'SitemapController@xmlPages');
Route::get('xml-sitemap/posts', 'SitemapController@xmlPosts');

Route::fallback('WebsiteController@article');
