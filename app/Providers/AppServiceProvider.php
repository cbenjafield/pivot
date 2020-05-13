<?php

namespace App\Providers;

use App\Organisation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer('components.sites.form', function ($view) {
            $organisations = Cache::rememberForever('organisations', function () {
                return Organisation::orderBy('name', 'asc')->get();
            });
            $view->with('organisations', $organisations);
        });
    }
}
