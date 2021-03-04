<?php

declare(strict_types=1);

namespace App\Containers\User\Tasks;

use App\Containers\User\Data\Criterias\RoleCriteria;
use App\Containers\User\Data\Repositories\UserRepository;
use App\Containers\User\Models\User;
use App\Ship\Criterias\Eloquent\OrderByCreationDateDescendingCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class GetAllUsersTask.
 */
class GetAllUsersTask extends Task
{
    protected UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return User[]|Collection
     */
    public function run()
    {
        return $this->repository->all();
    }

    /**
     * @throws RepositoryException
     */
    public function ordered(): void
    {
        $this->repository->pushCriteria(new OrderByCreationDateDescendingCriteria());
    }

    /**
     * @throws RepositoryException
     */
    public function withRole(string $roles): void
    {
        $this->repository->pushCriteria(new RoleCriteria($roles));
    }
}
