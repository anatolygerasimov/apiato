<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Providers;

use App\Containers\User\Events\Handlers\LogSuccessfulLogin;
use App\Ship\Parents\Providers\EventsProvider;
use Laravel\Passport\Events\AccessTokenCreated;

/**
 * Class EventServiceProvider.
 */
class EventServiceProvider extends EventsProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        AccessTokenCreated::class => [
            LogSuccessfulLogin::class,
        ],
    ];

    /**
     * Register any other events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
