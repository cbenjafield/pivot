<?php

namespace App\Pivot\Facades;

use Illuminate\Support\Facades\Facade;

class Theme extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'theme';
    }
}