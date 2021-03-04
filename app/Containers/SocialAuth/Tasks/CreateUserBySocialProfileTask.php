<?php

namespace App\Containers\SocialAuth\Tasks;

use App\Containers\SocialAuth\Exceptions\AccountFailedException;
use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Models\User;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class CreateUserBySocialProfileTask.
 */
class CreateUserBySocialProfileTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string      $provider
     * @param string|null $token
     * @param string|null $socialId
     * @param string|null $nickname
     * @param string|null $username
     * @param string|null $email
     * @param string|null $avatar
     * @param string|null $tokenSecret
     * @param string|null $expiresIn
     * @param string|null $refreshToken
     * @param string|null $avatar_original
     *
     * @return User
     *
     * @throws AccountFailedException
     */
    public function run(
        $provider,
        $token = null,
        $socialId = null,
        $nickname = null,
        $username = null,
        $email = null,
        $avatar = null,
        $tokenSecret = null,
        $expiresIn = null,
        $refreshToken = null,
        $avatar_original = null
    ) {
        $data = [
            'social_provider'        => $provider,
            'social_token'           => $token,
            'social_refresh_token'   => $refreshToken,
            'social_token_secret'    => $tokenSecret,
            'social_expires_in'      => $expiresIn,
            'social_id'              => $socialId,
            'social_nickname'        => $nickname,
            'social_avatar'          => $avatar,
            'social_avatar_original' => $avatar_original,
            'email'                  => $email,
            'username'               => $username,
        ];

        try {
            // create new user
            $user = $this->repository->create($data);
        } catch (Exception $e) {
            throw (new AccountFailedException())->debug($e);
        }

        return $user;
    }
}
