<?php

namespace App\Ship\Middlewares\Http;

use App\Ship\Parents\Providers\RoutesProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class RedirectIfAuthenticated
 *
 * A.K.A app/Http/Middleware/RedirectIfAuthenticated.php
 */
class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param Request     $request
     * @param Closure     $next
     * @param string|null ...$guards
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {

                if (optional(Auth::guard($guard)->user())->hasAdminRole()) {
                    return redirect(route(config('platform.index')));
                }

                return redirect(RoutesProvider::HOME);
            }
        }

        return $next($request);
    }
}
