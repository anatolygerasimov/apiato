<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\PermissionRepository;
use App\Containers\Authorization\Models\Permission;
use App\Ship\Parents\Tasks\Task;

/**
 * Class FindPermissionTask.
 */
class FindPermissionTask extends Task
{
    protected PermissionRepository $repository;

    public function __construct(PermissionRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param string|int $permissionNameOrId
     */
    public function run($permissionNameOrId): ?Permission
    {
        $query = is_numeric($permissionNameOrId) ? ['id' => $permissionNameOrId] : ['name' => $permissionNameOrId];

        return $this->repository->findWhere($query)->first();
    }
}
