<?php

declare(strict_types=1);

namespace App\Containers\User\Providers;

use App\Containers\User\Contracts\UserRepositoryInterface;
use App\Containers\User\Data\Repositories\UserRepository;
use App\Ship\Parents\Providers\MainProvider;

/**
 * Class MainServiceProvider.
 */
class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        EventServiceProvider::class,
    ];

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

        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
    }
}
