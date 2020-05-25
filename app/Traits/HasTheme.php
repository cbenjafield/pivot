<?php

namespace App\Traits;

trait HasTheme
{
    public function view($filename, array $data = [])
    {
        return view("");
    }
}