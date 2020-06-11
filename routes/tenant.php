<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'WebsiteController@index');

Route::fallback('WebsiteController@article');