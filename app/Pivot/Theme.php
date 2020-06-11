<?php

namespace App\Pivot;

class Theme
{
    protected $website;

    public function __construct($website)
    {
        $this->website = $website;
    }

    public function website()
    {
        return $this->website;
    }

    public function styles()
    {
        return asset(mix("themes/{$this->website->theme}/css/theme.css"));
    }

    public function layout($name)
    {
        return $this->website->themePath("layouts.{$name}");
    }

    public function partial($name)
    {
        return $this->website->themePath("partials.{$name}");
    }

    public function logo()
    {
        return view($this->website->themePath('partials.logo'), [
            'website' => $this->website
        ]);
    }

    public function image(string $image)
    {
        return asset("themes/{$this->website->theme}/images/{$image}");
    }

    public function menu($position, $theme = 'default')
    {
        $menu = $this->website->menus()
                                ->select('id')
                                ->where('position', $position)
                                ->with('items')
                                ->first();
        
        return view($this->website->themePath("menus.{$theme}"), [
            'menu' => $menu
        ]);
    }

    public function view($filename, array $data = [])
    {
        return view($this->website->themePath($filename), $data);
    }

}