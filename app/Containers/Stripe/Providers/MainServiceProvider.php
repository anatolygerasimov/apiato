<?php

namespace App\Containers\Stripe\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Cartalyst\Stripe\Laravel\Facades\Stripe;
use Cartalyst\Stripe\Laravel\StripeServiceProvider;

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
        StripeServiceProvider::class,
    ];

    /**
     * Container Aliases.
     */
    public array $aliases = [
        'Stripe' => Stripe::class,
    ];
}
