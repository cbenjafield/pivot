<?php

namespace App\Providers\Tenants;

use App\Pivot\Theme;
use App\Pivot\Article;
use Illuminate\Support\ServiceProvider;

class ThemeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('theme', function () {
            return new Theme(request('website'));
        });

        $this->app->bind('article', function () {
            return new Article(request('website'));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
