<?php

namespace App\Pivot\Facades;

use Illuminate\Support\Facades\Facade;

class Block extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'block';
    }
}