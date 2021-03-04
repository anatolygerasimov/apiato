<?php

namespace App\Containers\Debugger\Providers;

use App\Containers\Debugger\Tasks\QueryDebuggerTask;
use App\Ship\Parents\Providers\MainProvider;
use Illuminate\Database\DatabaseManager;
use Jenssegers\Agent\AgentServiceProvider;
use Jenssegers\Agent\Facades\Agent;

/**
 * Class MainServiceProvider.
 */
class MainServiceProvider extends MainProvider
{
    /**
     * Container Service Providers.
     */
    public array $serviceProviders = [
        AgentServiceProvider::class,
        MiddlewareServiceProvider::class,
    ];

    /**
     * Container Aliases.
     */
    public array $aliases = [
        'Agent' => Agent::class,
    ];

    /**
     * Register anything in the container.
     */
    public function register()
    {
        parent::register();

        (new QueryDebuggerTask())->run();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        if (config('app.debug')) {
            $this->app->get(DatabaseManager::class)->enableQueryLog();
        }
    }
}
