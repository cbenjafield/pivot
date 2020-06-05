<?php

namespace App\Pivot;

use App\Site;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Concerns\HasAttributes;
use Illuminate\Support\Facades\View;
use JsonSerializable;
use ParsedownExtra;

class Block
{
    protected $website;

    protected $attributes = [];

    public function __construct($website, array $attributes = [])
    {
        $this->website = $website;
        $this->fill($attributes);
    }

    public function fill(array $attributes)
    {
        foreach($attributes as $key => $value)
        {
            $this->setAttribute($key, $value);
        }
    }

    public function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    public function render()
    {
        return View::first([
            $this->website->themePath("components.{$this->type}"),
            "default.components.{$this->type}",
            "default.components.fallback",
        ], [
            'block' => $this
        ])->render();
    }

    public function __isset($key)
    {
        return ! is_null($this->getAttribute($key));
    }

    public function __set($key, $value)
    {
        $this->setAttribute($key, $value);
    }

    public function __get($key)
    {
        return $this->getAttribute($key);
    }

    public function markdown()
    {
        return (new ParsedownExtra)
                        ->text($this->content);
    }
}