<?php

namespace App\Pivot;

use App\ContactForm;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use ParsedownExtra;
use App\Site;

class Block
{
    protected $website;

    protected $attributes = [];

    public function __construct($website, array $attributes = [])
    {
        $this->website = $website;
        $this->fill($attributes);
        $this->runRenderMethods();
    }

    public static function make($block)
    {
        return new static(request('website'), $block->toArray());
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

    public function toArray()
    {
        return $this->attributes;
    }

    public function render()
    {
        $renderable = $this->getRenderableData();

        return View::first([
            $this->website->themePath("components.{$this->type}"),
            "default.components.{$this->type}",
            "default.components.fallback",
        ], [
            'block' => $this,
            'website' => $this->website,
            'renderable' => $renderable,
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

    protected function runRenderMethods()
    {
        $methodName = 'build' . Str::studly($this->type);

        if(method_exists($this, $methodName)) {
            $this->$methodName();
        }
    }

    protected function buildPivotPassrates()
    {
        $months = [];
        $bars = [];

        for($i = 1; $i < 4; $i++) {
            $months[] = [
                'day' => (integer) date('j', strtotime("-{$i} month")),
                'month' => (integer) date('n', strtotime("-{$i} month")),
                'year' => (integer) date('Y', strtotime("-{$i} month")),
            ];
        }
        
        asort($months);

        $values = [93, 94, 90];

        foreach($months as $key => $m) {
            $date = mktime(0, 0, 0, $m['month'], $m['day'], $m['year']);

            $bars[] = [
                'title' => date('F Y', $date),
                'value' => $values[$key],
            ];
        }

        $avg = floor(array_sum($values) / count($values));

        $bars[] = [
            'title' => 'Average',
            'value' => $avg,
        ];

        $this->setAttribute('bars', $bars);
    }

    protected function getRenderableData()
    {
        switch($this->type) {
            default:
                return null;
            case 'pivot-contact':
                return $this->getContactForm();
        }
    }

    protected function getContactForm()
    {
        return ContactForm::find($this->content['form']);
    }
}