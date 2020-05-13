<?php

namespace App\View\Components\Sites;

use Illuminate\View\Component;

class Health extends Component
{
    public $health;

    public $width;

    public $height;

    public $size;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($health, $width = '6', $height = '6', $size = 'base')
    {
        $this->health = $health;
        $this->width = $width;
        $this->height = $height;
        $this->size = $size;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sites.health');
    }
}
