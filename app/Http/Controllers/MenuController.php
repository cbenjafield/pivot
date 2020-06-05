<?php

namespace App\Http\Controllers;

use App\Menus\Menu;
use App\Site;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    
    /**
     * Show the menu for this website.
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function index(Site $website)
    {
        $menus = $website->menus()->get();

        return view('menus.index', compact('website', 'menus'));
    }

    /**
     * Show the form to create a menu.
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function create(Site $website)
    {
        return view('menus.create', compact('website'));
    }

    /**
     * Commit the new menu to storage.
     * 
     * @param  \App\Site  $website
     * @return \Illuminate\Http\Response
     */
    public function store(Site $website)
    {
        $this->validate(request(), [
            'title' => ['required'],
            'position' => [
                'required',
                Rule::in(['primary', 'secondary']),
            ]
        ]);

        $menu = $website->menus()->create([
            'title' => request('title'),
            'position' => request('position'),
        ]);

        if(is_array(request('items'))) {
            $menu->attachItems(request('items'));
        }

        return response()->json([
            'redirect_url' => route('menus.show', [$website->id, $menu->id])
        ], 201);
    }

    /**
     * Show the form to edit a menu.
     * 
     * @param  \App\Site  $website
     * @param  \App\Menus\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show(Site $website, Menu $menu)
    {
        $menu->load('items');

        return view('menus.show', compact('menu', 'website'));
    }

    /**
     * Update the menu in storage.
     * 
     * @param  \App\Site  $website
     * @param  \App\Menus\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Site $website, Menu $menu)
    {
        $this->validate(request(), [
            'title' => ['required'],
            'position' => [
                'required',
                Rule::in(['primary', 'secondary']),
            ]
        ]);

        $menu->update([
            'title' => request('title'),
            'position' => request('position'),
        ]);

        if(is_array(request('items')) && !empty(request('items'))) {
            $menu->items()->delete();
            $menu->attachItems(request('items'));
        }

        $menu->load('items');

        return response()->json([
            'menu' => $menu
        ], 200);
    }

}
