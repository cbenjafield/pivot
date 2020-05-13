<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait HasUrl
{

    protected static function getRouteName()
    {
        return Str::plural(strtolower(class_basename(static::class)));
    }

    protected function url()
    {
        return route(static::getRouteName() . '.show', [$this->id]);
    }

}