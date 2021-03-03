<?php

namespace App\Ship\Providers;

use App\Ship\Parents\Providers\MainProvider;
use Barryvdh\Debugbar\Facade;
use Barryvdh\Debugbar\ServiceProvider;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;

/**
 * Class ShipProvider.
 */
class ShipProvider extends MainProvider
{
    /**
     * Register any Service Providers on the Ship layer (including third party packages).
     *
     * @var array
     */
    public $serviceProviders = [];

    /**
     * Register any Alias on the Ship layer (including third party packages).
     *
     * @var array
     */
    protected $aliases = [];

    public function __construct()
    {
        parent::__construct(app());

        if (class_exists('Barryvdh\Debugbar\ServiceProvider')) {
            $this->serviceProviders[] = ServiceProvider::class;
        }

        if (class_exists('Barryvdh\Debugbar\Facade')) {
            $this->aliases['Debugbar'] = Facade::class;
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        /**
         * Load the ide-helper service provider only in non production environments.
         */
        if ($this->app->environment() !== 'production' && class_exists('Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider')) {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        parent::register();
    }
}
