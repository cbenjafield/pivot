<?php

namespace App\Http\Controllers\Tenants;

use App\Article;
use App\Http\Controllers\Controller;
use App\Site;
use App\Traits\HasTheme;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    use HasTheme;

    public function index()
    {
        return request('website')->hasHomePage()
                    ? $this->homepage()
                    : $this->showIndex();
    }

    protected function homepage()
    {
        $page = request('website')->homepage;

        return $this->view('home', compact('page'));
    }

}
