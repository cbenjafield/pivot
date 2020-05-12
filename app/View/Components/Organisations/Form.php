<?php

namespace App\View\Components\Organisations;

use App\Organisation;
use Illuminate\View\Component;

class Form extends Component
{
    public $method;

    public $action;

    public $organisation;

    public $id;

    public $ref;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($organisation = null, $id = null, $ref = null)
    {
        if(is_null($organisation)) {
            $organisation = new Organisation;
        }

        $this->id = $id;
        $this->ref = $ref;
        $this->organisation = $organisation;
        $this->method = $this->organisation->exists ? 'PUT' : 'POST';
        $this->action = $this->organisation->exists ?
                                    route('organisations.update', $this->organisation->id) : 
                                    route('organisations.store');
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\View\View|string
     */
    public function render()
    {
        return view('components.organisations.form');
    }
}
