<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sites\CreateRequest;
use App\Http\Requests\Sites\UpdateRequest;
use App\Site;
use App\Traits\HasUrl;
use App\Traits\ResourceViews;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    use ResourceViews, HasUrl;
    /**
     * Show a list of all sites.
     * 
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sites = Site::orderBy('title', 'asc')
                            ->paginate(request('perpage') ?? 10);

        return $this->view('index', compact('sites'));
    }

    /**
     * Show the form to create a new website.
     * 
     * @return  \Illuminate\Http\Response
     */
    public function create()
    {
        return $this->view('create');
    }

    /**
     * Commit the new website to storage.
     * 
     * @param  \App\Http\Requests\Sites\CreateRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateRequest $request)
    {
        return Site::createFromUserRequest($request);
    }

    /**
     * Update a website.
     * 
     * @param  \App\Http\Requests\Sites\UpdateRequest  $request
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, Site $website)
    {
        return $website->updateFromUserRequest($request);
    }

    /**
     * Show a website.
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function show(Site $website)
    {
        $rootPages = $website->pages()->root()->published()->get();
        $website->checkHealth();
        return $this->view('show', compact('website', 'rootPages'));
    }

    /**
     * Delete a website from storage
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function destroy(Site $website)
    {
        $website->delete();

        return redirect()->route('sites.index')
                                ->with('success', 'The website was deleted.');
    }

    public function updateDetails(Site $website)
    {
        $this->validate(request(), [
            'home_page_id' => ['required', 'integer', 'exists:articles,id'],
        ]);

        $website->update(request()->only([
            'home_page_id'
        ]));

        return back()
                    ->with('success', 'Successfully saved.');
    }
}