<?php

namespace App\Ship\Core\Providers;

use App\Ship\Core\Abstracts\Providers\MainProvider as AbstractMainProvider;
use App\Ship\Core\Foundation\Apiato;
use App\Ship\Core\Generator\GeneratorsServiceProvider;
use App\Ship\Core\Loaders\AutoLoaderTrait;
use App\Ship\Core\Loaders\FactoriesLoaderTrait;
use App\Ship\Core\Traits\ValidationTrait;
use App\Ship\Parents\Providers\RoutesProvider;
use App\Ship\Providers\ShipProvider;
use Fruitcake\Cors\CorsServiceProvider;
use Illuminate\Support\Facades\Schema;
use Laravel\Tinker\TinkerServiceProvider;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Dashboard;
use Prettus\Repository\Providers\RepositoryServiceProvider;
use Sentry\Laravel\Facade;
use Sentry\Laravel\ServiceProvider as SentryLaravelServiceProvider;
use Sentry\Laravel\Tracing\ServiceProvider;
use Spatie\Fractal\FractalFacade;
use Spatie\Fractal\FractalServiceProvider;
use Tabuna\Breadcrumbs\Breadcrumbs;
use Vinkla\Hashids\Facades\Hashids;
use Vinkla\Hashids\HashidsServiceProvider;
use Watson\Active\Facades\Active;

/**
 * Class ApiatoProvider
 * Does not have to extend from the Ship parent MainProvider since it's on the Core
 * it directly extends from the Abstract MainProvider.
 */
class ApiatoProvider extends AbstractMainProvider
{
    use AutoLoaderTrait;
    use FactoriesLoaderTrait;
    use ValidationTrait;

    private const DEFAULT_STRING_LENGTH = 191;

    /**
     * Register any Service Providers on the Ship layer (including third party packages).
     *
     * @var array
     */
    public $serviceProviders = [
        // Third Party Packages Providers:
        HashidsServiceProvider::class,
        RepositoryServiceProvider::class,
        CorsServiceProvider::class,
        FractalServiceProvider::class,

        // add the Laravel Tinker Service Provider
        TinkerServiceProvider::class,

        // Internal Apiato Providers:
        RoutesProvider::class, // exceptionally adding the Route Provider, unlike all other providers in the parents.
        ShipProvider::class, // the ShipProvider for the Ship third party packages.
        GeneratorsServiceProvider::class, // the code generator provider.

        // Sentry
        SentryLaravelServiceProvider::class,
        ServiceProvider::class,
    ];

    /**
     * Register any Alias on the Ship layer (including third party packages).
     *
     * @var array
     */
    protected $aliases = [
        'Hashids'     => Hashids::class,
        'Fractal'     => FractalFacade::class,

        // Need for App\Containers\Orchid admin panel
        'Alert'       => Alert::class,
        'Dashboard'   => Dashboard::class,
        'Breadcrumbs' => Breadcrumbs::class,
        'Active'      => Active::class,

        // Sentry
        'Sentry'      => Facade::class,
    ];

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Autoload most of the Containers and Ship Components
        $this->runLoadersBoot();

        // load all service providers defined in this class
        parent::boot();

        /**
         * Solves the "specified key was too long" error, introduced in L5.4.
         *
         * @see https://laravel.com/docs/8.x/migrations#index-lengths-mysql-mariadb
         */
        Schema::defaultStringLength(self::DEFAULT_STRING_LENGTH);

        // Registering custom validation rules
        $this->extendValidationRules();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        parent::register();

        $this->overrideLaravelBaseProviders();

        /**
         * @FIXME : thinking about change this approach
         * Register Core Facade Classes, should not be registered in the alias property above, since they are used
         * by the auto-loading scripts, before the $aliases property is executed.
         */
        $this->app->alias(Apiato::class, 'Apiato');
    }

    /**
     * Register Override Base providers.
     *
     * @return void
     *
     * @see   \Illuminate\Foundation\Application::registerBaseServiceProviders
     */
    private function overrideLaravelBaseProviders()
    {
    }
}
