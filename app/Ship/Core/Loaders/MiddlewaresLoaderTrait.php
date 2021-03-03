<?php

namespace App\Ship\Core\Loaders;

use App;
use Illuminate\Contracts\Http\Kernel;

/**
 * Class MiddlewaresLoaderTrait.
 */
trait MiddlewaresLoaderTrait
{
    /**
     * @void
     */
    public function loadMiddlewares()
    {
        $this->registerMiddleware($this->middlewares);
        $this->registerMiddlewareGroups($this->middlewareGroups);
        $this->registerRouteMiddleware($this->routeMiddleware);
    }

    /**
     * Registering Route Group's
     *
     * @param array $middlewares
     */
    private function registerMiddleware(array $middlewares = [])
    {
        $httpKernel = $this->app->make(Kernel::class);

        foreach ($middlewares as $middleware) {
            $httpKernel->prependMiddleware($middleware);
        }
    }

    /**
     * Registering Route Group's
     *
     * @param array $middlewareGroups
     */
    private function registerMiddlewareGroups(array $middlewareGroups = [])
    {
        foreach ($middlewareGroups as $key => $middleware) {
            if (!is_array($middleware)) {
                $this->app['router']->pushMiddlewareToGroup($key, $middleware);
            } else {
                foreach ($middleware as $item) {
                    $this->app['router']->pushMiddlewareToGroup($key, $item);
                }
            }
        }
    }

    /**
     * Registering Route Middleware's
     *
     * @param array $routeListMiddleware
     */
    private function registerRouteMiddleware(array $routeListMiddleware = [])
    {
        foreach ($routeListMiddleware as $key => $routeMiddleware) {
            $this->app['router']->aliasMiddleware($key, $routeMiddleware);
        }
    }
}
