<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait ResourceViews
{
    protected function getResourceName()
    {
        return Str::plural( 
            strtolower(
                str_replace(
                    'Controller', '',
                    class_basename(request()->route()->controller)
                )
            )
        );
    }

    protected function view($path, $data = [])
    {
        return view(
            (!is_null($this->getResourceName()) ? $this->getResourceName() . '.' : '')
            . $path,
            $data
        );
    }
}