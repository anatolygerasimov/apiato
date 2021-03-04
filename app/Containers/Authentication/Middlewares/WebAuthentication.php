<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Middlewares;

use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Middlewares\Middleware;
use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;

/**
 * Class WebAuthentication.
 */
class WebAuthentication extends Middleware
{
    /**
     * The Guard implementation.
     */
    protected Guard $auth;

  /**
   * WebAuthentication constructor.
   * @param Guard $auth
   */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

  /**
   * Handle an incoming request.
   *
   * @param Request $request
   * @param Closure $next
   * @return Application|RedirectResponse|Redirector|mixed
   */
    public function handle(Request $request, Closure $next)
    {
        if ($this->auth->guest()) {
            return redirect(Apiato::getLoginWebPageName())
                ->with('errorMessage', 'Credentials Incorrect.');
        }

        return $next($request);
    }
}
