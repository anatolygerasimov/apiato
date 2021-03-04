<?php

namespace App\Containers\SocialAuth\Tasks;

use App\Containers\SocialAuth\Exceptions\UnsupportedSocialAuthProviderException;
use App\Ship\Parents\Tasks\Task;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\One\AbstractProvider as TwitterAbstractProvider;
use Laravel\Socialite\One\User as UserOne;
use Laravel\Socialite\Two\AbstractProvider as FacebookAbstractProvider;
use Laravel\Socialite\Two\User as UserTwo;

/**
 * Class FindUserSocialProfileTask.
 */
class FindUserSocialProfileTask extends Task
{
    /**
     * @param string|null $provider
     *
     * @return UserOne|UserTwo
     *
     * @throws UnsupportedSocialAuthProviderException
     */
    public function run($provider, array $requestData = null)
    {
        switch ($provider) {
            case 'facebook':
                /** @var FacebookAbstractProvider $provider */
                $provider = Socialite::driver($provider);
                $user     = $provider->userFromToken($requestData['oauth_token'] ?? '');
                break;
            case 'twitter':
                /** @var TwitterAbstractProvider $provider */
                $provider = Socialite::driver($provider);
                $user     = $provider->userFromTokenAndSecret(
                                $requestData['oauth_token'] ?? '',
                                $requestData['oauth_secret'] ?? ''
                            );
                break;
            default:
                throw new UnsupportedSocialAuthProviderException("The Social Auth Provider $provider is unsupported.");
        }

        return $user;
    }
}
