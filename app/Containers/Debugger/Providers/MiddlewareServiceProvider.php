<?php

namespace App\Containers\Debugger\Providers;

use App\Containers\Debugger\Middlewares\RequestsMonitorMiddleware;
use App\Ship\Middlewares\Http\QueryStatsHeaders;
use App\Ship\Parents\Providers\MiddlewareProvider;
use Illuminate\Contracts\Http\Kernel;

/**
 * Class MiddlewareServiceProvider.
 */
class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * Register Container Middleware Groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'web' => [

        ],
        'api' => [

        ],
    ];

    public function boot()
    {
        parent::boot();

        if (config('app.debug')) {
            $this->app->make(Kernel::class)->appendMiddlewareToGroup('api', QueryStatsHeaders::class);
        }

        if (config('debugger.requests.debug')) {
            $this->app->make(Kernel::class)->prependMiddleware(RequestsMonitorMiddleware::class);
        }
    }
}
