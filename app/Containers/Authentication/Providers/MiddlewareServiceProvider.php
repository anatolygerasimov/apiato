<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Providers;

use App\Containers\Authentication\Middlewares\WebAuthentication;
use App\Ship\Parents\Providers\MiddlewareProvider;

/**
 * Class MiddlewareServiceProvider.
 */
class MiddlewareServiceProvider extends MiddlewareProvider
{
    /**
     * Register Middlewares.
     *
     * @var array
     */
    protected $middlewares = [
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
     * Blocks User Authentication middleware for Web Pages.
     *
     * @var array<array-key, string>
     */
    protected $routeMiddleware = [
        'auth:web' => WebAuthentication::class,
    ];
}
