<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Laravel\Passport\PassportServiceProvider;

/**
 * Class MainServiceProvider.
 *
 * The Main Service Provider of this container, it will be automatically registered in the framework.
 */
class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        PassportServiceProvider::class,
        AuthProvider::class,
        MiddlewareServiceProvider::class,
        EventServiceProvider::class,
    ];

    /**
     * Manual listen db queries
     * Perform post-registration booting of services.
     */
    public function boot()
    {
        parent::boot();

        if (in_array(config('app.env'), config('debugbar.env_db_listen'), true)) {
            DB::listen(function (QueryExecuted $query) {
                info('TEST_CALL_API', [
                    $query->sql,
                    $query->bindings,
                    $query->time,
                ]);
            });
        }
    }
}
