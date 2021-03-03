<?php

namespace App\Ship\Core\Abstracts\Providers;

use App\Ship\Core\Loaders\RoutesLoaderTrait;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as LaravelRouteServiceProvider;

/**
 * Class RoutesProvider
 */
class RoutesProvider extends LaravelRouteServiceProvider
{
    use RoutesLoaderTrait;

    /**
     * The path to the "home" route for your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const HOME = '/';

    /**
     * Define your route model bindings, pattern filters, etc.
     */
    public function boot()
    {
        $this->configureRateLimiting();
        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->runRoutesAutoLoader();
    }
}
