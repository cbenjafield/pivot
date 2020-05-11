<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    
    /**
     * Show the logged in user's dashboard.
     */
    public function index()
    {
        return view('dashboard');
    }

}
