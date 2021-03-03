<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\Authorization\Models\Permission;
use App\Ship\Criterias\Eloquent\ThisEqualThatCriteria;
use App\Ship\Parents\Tasks\Task;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * Class GetAllPermissionsTask.
 */
class GetAllPermissionsTask extends Task
{
    protected PermissionRepository $repository;

    /**
     * GetAllPermissionsTask constructor.
     */
    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return Collection|array<array-key, Permission>
     */
    public function run(bool $skipPagination = false)
    {
        return $skipPagination ? $this->repository->all() : $this->repository->paginate();
    }

    /**
     * @throws RepositoryException
     */
    public function filterByGuard(string $guard): PermissionRepository
    {
        return $this->repository->pushCriteria(new ThisEqualThatCriteria('guard_name', $guard));
    }
}
