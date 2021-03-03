<?php

namespace App\Ship\Middlewares\Http;

use App\Containers\Authentication\Exceptions\AuthenticationException;
use App\Ship\Core\Foundation\Facades\Apiato;
use Exception;
use Illuminate\Auth\Middleware\Authenticate as LaravelAuthenticate;
use Illuminate\Http\Request;

/**
 * Class Authenticate
 */
class Authenticate extends LaravelAuthenticate
{
    /**
     * @inheritDoc
     */
    public function authenticate($request, array $guards)
    {
        try {
            parent::authenticate($request, $guards);
        } catch (Exception $exception) {
            throw new AuthenticationException(
                null, $guards, $this->redirectTo($request)
            );
        }
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     *
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if ($request->expectsJson()) {
            return null;
        }

        return route(Apiato::getLoginWebPageName());
    }
}
