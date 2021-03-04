<?php

declare(strict_types=1);

namespace App\Containers\User\Tasks;

use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Models\User;
use App\Ship\Exceptions\CreateResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;
use Illuminate\Support\Facades\Hash;

/**
 * Class CreateUserByCredentialsTask.
 */
class CreateUserByCredentialsTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(
        string $email,
        string $password,
        string $username,
        bool $isClient = true
    ): User {
        try {
            // create new user
            return $this->repository->create([
                'password'  => Hash::make($password),
                'email'     => $email,
                'username'  => $username,
                'is_client' => $isClient,
            ]);
        } catch (Exception $e) {
            throw (new CreateResourceFailedException())->debug($e);
        }
    }
}
