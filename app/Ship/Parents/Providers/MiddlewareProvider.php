<?php

namespace App\Ship\Parents\Providers;

use App\Ship\Core\Abstracts\Providers\MiddlewareProvider as AbstractMiddlewareProvider;

/**
 * Class MiddlewareProvider
 */
abstract class MiddlewareProvider extends AbstractMiddlewareProvider
{
    /**
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register anything in the container.
     */
    public function register()
    {
        parent::register();
    }
}
