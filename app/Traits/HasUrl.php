<?php

namespace App\Traits;

trait HasUrl
{

    protected function url()
    {
        return route('organisations.show', [$this->id]);
    }

}