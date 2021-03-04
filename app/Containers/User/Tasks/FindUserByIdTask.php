<?php

declare(strict_types=1);

namespace App\Containers\User\Tasks;

use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Models\User;
use App\Ship\Exceptions\NotFoundException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class FindUserByIdTask.
 */
class FindUserByIdTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    public function run(int $userId): ?User
    {
        try {
            return $this->repository->find($userId);
        } catch (Exception $e) {
            throw new NotFoundException();
        }
    }
}
