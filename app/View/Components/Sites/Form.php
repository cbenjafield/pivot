<?php

namespace App\View\Components\Sites;

use App\Site;
use Illuminate\View\Component;

class Form extends Component
{
    public $method;

    public $action;

    public $site;

    public $id;

    public $ref;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($site = null, $id = null, $ref = null)
    {
        if(is_null($site)) {
            $site = new Site;
        }

        $this->id = $id;
        $this->ref = $ref;
        $this->site = $site;
        $this->method = $this->site->exists ? 'PUT' : 'POST';
        $this->action = $this->site->exists ?
                                    route('sites.update', $this->site->id) : 
                                    route('sites.store');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.sites.form');
    }
}
