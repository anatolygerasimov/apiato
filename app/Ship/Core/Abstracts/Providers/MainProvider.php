<?php

namespace App\Ship\Core\Abstracts\Providers;

use App\Ship\Core\Loaders\AliasesLoaderTrait;
use App\Ship\Core\Loaders\ProvidersLoaderTrait;
use Illuminate\Support\ServiceProvider as LaravelAppServiceProvider;

/**
 * Class MainProvider
 *
 * A.K.A (app/Providers/AppServiceProvider.php)
 */
abstract class MainProvider extends LaravelAppServiceProvider
{
    use ProvidersLoaderTrait;
    use AliasesLoaderTrait;

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadServiceProviders();
        $this->loadAliases();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
