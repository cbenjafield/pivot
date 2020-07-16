<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WebsiteController@index');
Route::post('contact/{form}', 'ContactController@submitForm');

Route::fallback('WebsiteController@article');