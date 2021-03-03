<?php

namespace App\Containers\Authorization\Providers;

use App\Ship\Parents\Providers\MiddlewareProvider;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Routing\Middleware\SubstituteBindings;

/**
 * Class MiddlewareServiceProvider.
 */
class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * Register Middleware's.
     *
     * @var array
     */
    protected $middlewares = [
        // ..
    ];

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

    /**
     * @var array<string, class-string<Authorize>|class-string<SubstituteBindings>>
     */
    protected $routeMiddleware = [
        // Laravel default route middlewares:
        'can'      => Authorize::class,
        'bindings' => SubstituteBindings::class,
    ];
}
