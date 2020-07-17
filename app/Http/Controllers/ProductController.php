<?php

namespace App\Http\Controllers;

use App\Site;
use App\Traits\ResourceViews;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use ResourceViews;

    public function index(Site $website)
    {
        $products = $website->products()->get();

        return $this->view('index', compact('website', 'products'));
    }
}
