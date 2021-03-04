<?php

namespace App\Containers\SocialAuth\UI\WEB\Controllers;

use App\Ship\Parents\Controllers\WebController;
use Laravel\Socialite\Contracts\User;
use Laravel\Socialite\Facades\Socialite;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Class Controller.
 */
class Controller extends WebController
{
    /**
     * @param string $provider
     *
     * @return RedirectResponse
     */
    public function redirectAll($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * @param string $provider
     *
     * @return User
     */
    public function handleCallbackAll($provider)
    {
        return Socialite::driver($provider)->user();
    }
}
