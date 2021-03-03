<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Providers;

use App\Containers\Authentication\Events\Observers\UserObserver;
use App\Containers\Authentication\Passport\PkceClient;
use App\Containers\User\Models\User;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Core\Loaders\RoutesLoaderTrait;
use App\Ship\Parents\Providers\AuthProvider as ParentAuthProvider;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\Passport;
use Laravel\Passport\RouteRegistrar;
use Route;

/**
 * Class AuthProvider.
 */
class AuthProvider extends ParentAuthProvider
{
    use RoutesLoaderTrait;

    /**
     * Indicates if loading of the provider is deferred.
     */
    protected bool $defer = true;

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerCacheUserAuth();

        $this->registerPolicies();

        $this->registerPassport();
        $this->registerPassportApiRoutes();
        $this->registerPassportWebRoutes();
    }

    /**
     * Register registerCacheUserAuth.
     *
     * @return void
     */
    private function registerCacheUserAuth()
    {
        // Register caching user provider
        Auth::provider('cache-user', fn () => resolve(CacheUserProvider::class));

        // Register user observer for keep in cache actual data
        User::observe(UserObserver::class);
    }

    /**
     * Register password.
     *
     * @return void
     */
    private function registerPassport()
    {
        Passport::loadKeysFrom(base_path('/secret-keys/oauth'));

        if (config('apiato.api.enabled-implicit-grant')) {
            Passport::enableImplicitGrant();
        }

        if (config('apiato.api.enabled-first-party-pkce-client')) {
            Passport::useClientModel(PkceClient::class);
        }

        if (config('apiato.api.enabled-client-secret-hashing')) {
            Passport::hashClientSecrets();
        }

        Passport::tokensExpireIn(now()->addMinutes(config('apiato.api.expires-in')));

        Passport::refreshTokensExpireIn(now()->addMinutes(config('apiato.api.refresh-expires-in')));

        if (config('apiato.api.enabled-password-grant-client')) {
            Passport::personalAccessTokensExpireIn(now()->addMonths(config('apiato.api.expires-in')));
        }
    }

    /**
     * Register password api routes.
     *
     * @return void
     */
    private function registerPassportApiRoutes()
    {
        $routeGroupArray = $this->getApiRouteGroup(Apiato::getApiPrefix() . Apiato::getApiVersion());

        Route::group($routeGroupArray, function () {
            Passport::routes(function (RouteRegistrar $router) {
                $router->forAccessTokens();
                $router->forTransientTokens();
                $this->registerPersonalClientRoutes($router);
            });
        });
    }

    /**
     * Register Personal Client routes.
     *
     *
     * @return void
     */
    private function registerPersonalClientRoutes(RouteRegistrar $router)
    {
        if (config('blocks.api.enabled-password-grant-client')) {
            $router->forClients();
            $router->forPersonalAccessTokens();
        }
    }

    /**
     * Register password web routes.
     *
     * @return void
     */
    private function registerPassportWebRoutes()
    {
        Passport::routes(function (RouteRegistrar $router) {
            $router->forAuthorization();
        });
    }
}
