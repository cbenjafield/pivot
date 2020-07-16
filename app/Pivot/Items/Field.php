<?php

namespace App\Pivot\Items;

use App\Site;
use Illuminate\Support\Facades\View;

class Field
{
    protected $attributes = [];

    protected $website;

    public function __construct(array $attributes = [], Site $website = null)
    {
        $this->attributes = $attributes;
        $this->website = $website;
    }

    public function get($key)
    {
        return $this->attributes[$key] ?? null;
    }

    public function isset($key)
    {
        return isset($this->attributes[$key]);
    }

    public function __get($key)
    {
        return $this->get($key);
    }

    public function view()
    {
        return View::first([
            $this->website->themePath("components.contact.{$this->type}"),
            "default.components.contact.{$this->type}",
            "default.components.fallback",
        ], [
            'field' => $this
        ])->render();
    }
}