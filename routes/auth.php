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
});

Route::resource('organisations', 'OrganisationController')
                        ->names('organisations')
                        ->except(['edit', 'destroy']);


Route::resource('websites', 'SiteController')
                        ->names('sites')
                        ->except(['edit', 'destroy']);