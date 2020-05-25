<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * The path to the "home" route for your application.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapSubdomainRoutes();

        $this->mapApiRoutes();

        $this->mapWebRoutes();

        $this->mapAuthRoutes();
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->domain(env('APP_DOMAIN'))
            ->namespace($this->namespace)
            ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group(base_path('routes/api.php'));
    }

    /**
     * Define the "auth" routes for the application.
     *
     * These routes require the user to be logged in.
     *
     * @return void
     */
    protected function mapAuthRoutes()
    {
        Route::middleware(['web', 'auth'])
                ->domain(env('APP_DOMAIN'))
                ->namespace($this->namespace)
                ->group(base_path('routes/auth.php'));
    }

    /**
     * Define the sub-domain routes for the application.
     * 
     * @return void
     */
    protected function mapSubdomainRoutes()
    {
        Route::middleware(['web'])
                ->domain('{website}.'.env('APP_DOMAIN'))
                ->namespace($this->namespace . '\Subdomain')
                ->group(base_path('routes/subdomain.php'));
    }
}
