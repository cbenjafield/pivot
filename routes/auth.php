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

Route::resource('organisations', 'OrganisationController')->names('organisations');