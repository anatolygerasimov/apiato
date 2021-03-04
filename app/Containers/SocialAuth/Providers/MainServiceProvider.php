<?php

namespace App\Containers\SocialAuth\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\SocialiteServiceProvider;

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
        SocialiteServiceProvider::class,
    ];

    /**
     * Container Aliases.
     */
    public array $aliases = [
        'Socialite' => Socialite::class,
    ];

    /**
     * Register anything in the container.
     */
    public function register()
    {
        parent::register();
    }
}
