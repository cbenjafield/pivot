<?php

namespace App\Http\Controllers;

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

}
