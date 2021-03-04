<?php

namespace App\Containers\SocialAuth\Tasks;

use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Models\User;
use App\Ship\Exceptions\UpdateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Prettus\Validator\Exceptions\ValidatorException;

/**
 * Class UpdateUserSocialProfileTask.
 */
class UpdateUserSocialProfileTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int         $userId
     * @param string|null $token
     * @param string|null $expiresIn
     * @param string|null $refreshToken
     * @param string|null $tokenSecret
     * @param string|null $provider
     * @param string|null $avatar
     * @param string|null $avatarOriginal
     * @param string|null $socialId
     * @param string|null $nickname
     * @param string|null $username
     * @param string|null $email
     *
     * @return mixed
     *
     * @throws UpdateResourceFailedException|ValidatorException
     */
    public function run(
        $userId,
        $token = null,
        $expiresIn = null,
        $refreshToken = null,
        $tokenSecret = null,
        $avatar = null,
        $avatarOriginal = null,
        $provider = null,
        $socialId = null,
        $nickname = null,
        $username = null,
        $email = null
    ): User {
        $attributes = [];

        if ($token) {
            $attributes['social_token'] = $token;
        }

        if ($expiresIn) {
            $attributes['social_expires_in'] = $expiresIn;
        }

        if ($refreshToken) {
            $attributes['social_refresh_token'] = $refreshToken;
        }

        if ($tokenSecret) {
            $attributes['social_token_secret'] = $tokenSecret;
        }

        if ($provider) {
            $attributes['social_provider'] = $provider;
        }

        if ($avatar) {
            $attributes['social_avatar'] = $avatar;
        }

        if ($avatarOriginal) {
            $attributes['social_avatar_original'] = $avatarOriginal;
        }

        if ($socialId) {
            $attributes['social_id'] = $socialId;
        }

        if ($nickname) {
            $attributes['social_nickname'] = $nickname;
        }

        if ($username) {
            $attributes['username'] = $username;
        }

        if ($email) {
            $attributes['email'] = $email;
        }

        // check if data is empty
        if (empty($attributes)) {
            throw new UpdateResourceFailedException('Inputs are empty.');
        }

        // updating the attributes
        return $this->repository->update($attributes, $userId);
    }
}
