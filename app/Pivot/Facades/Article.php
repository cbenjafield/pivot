<?php

namespace App\Pivot\Facades;

use Illuminate\Support\Facades\Facade;

class Article extends Facade
{
    public static function getFacadeAccessor()
    {
        return 'article';
    }
}