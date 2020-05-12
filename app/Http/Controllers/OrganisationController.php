<?php

namespace App\Http\Controllers;

use App\Http\Requests\Organisations\OrganisationRequest;
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
     * @param  \App\Http\Requests\Organisations\OrganisationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(OrganisationRequest $request)
    {
        return Organisation::createFromUserRequest($request);
    }

    /**
     * Show the form to edit an organisation.
     * 
     * @param  \App\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function show(Organisation $organisation)
    {
        return $this->view('edit', compact('organisation'));
    }

    /**
     * Update the organisation.
     * 
     * @param  \App\Http\Requests\Organisations\OrganisationRequest  $request
     * @param  \App\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function update(OrganisationRequest $request, Organisation $organisation)
    {
        return $organisation->updateFromUserRequest($request);
    }

    /**
     * Destroy an organisation.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Organisation  $organisation
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Organisation $organisation)
    {
        $organisation->delete();
        return redirect()->route('organisations.index');
    }
}
