<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organisations\CreateRequest;
use App\Organisation;
use App\Traits\ResourceViews;
use Illuminate\Http\Request;

class OrganisationController extends Controller
{
    use ResourceViews;

    /**
     * Display a list of all the organisations.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $organisations = Organisation::orderBy('name', 'asc')
                                        ->get();

        return $this->view('index', compact('organisations'));
    }

    /**
     * Display the form to create a new organisation.
     * 
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view('create');
    }

    /**
     * Commit the newly created organisations to storage.
     * 
     * @param  \App\Http\Requests\Organisations\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        return Organisation::createFromUserRequest($request);
    }
}
