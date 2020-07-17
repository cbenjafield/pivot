<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Declarations of the routes which require a user to be authenticated.
| These are all protected by the web and auth middleware.
|
*/
Route::get('/', 'DashboardController@index');
Route::get('logout', 'Auth\LoginController@logout');

Route::group(['middleware' => 'password.confirm'], function () {
    Route::any('organisations/{organisation}/delete', 'OrganisationController@destroy')->name('organisations.destroy');
    Route::any('websites/{website}/delete', 'SiteController@destroy')->name('sites.destroy');
});

Route::resource('organisations', 'OrganisationController')
                        ->names('organisations')
                        ->except(['edit', 'destroy']);


Route::resource('websites/{website}/articles', 'ArticleController');
Route::put('websites/{website}/details', 'SiteController@updateDetails')->name('sites.details');

Route::resource('websites', 'SiteController')
                        ->names('sites')
                        ->except(['edit', 'destroy']);

Route::group(['prefix' => 'websites/{website}/menus'], function () {
    Route::get('/', 'MenuController@index')->name('menus.index');
    Route::get('create', 'MenuController@create')->name('menus.create');
    Route::get('{menu}', 'MenuController@show')->name('menus.show');
    Route::put('{menu}', 'MenuController@update');
    Route::post('/', 'MenuController@store');
    Route::put('{menu}', 'MenuController@update');
});

Route::group(['prefix' => 'websites/{website}'], function () {
    Route::get('media/all', 'MediaController@all')->name('media.all');
    Route::resource('media', 'MediaController')->names('media');
    Route::resource('contact', 'ContactController')->names('contact');
    Route::resource('products', 'ProductController')->names('product');
});