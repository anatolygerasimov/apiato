<?php

declare(strict_types=1);

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Containers\Authorization\Models\Role;
use App\Ship\Parents\Tasks\Task;

/**
 * Class FindRoleTask.
 */
class FindRoleTask extends Task
{
    protected RoleRepository $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int|string $roleNameOrId
     */
    public function run($roleNameOrId): ?Role
    {
        $field = is_numeric($roleNameOrId) ? 'id' : 'name';

        return $this->repository->findWhere([$field => $roleNameOrId])->first();
    }
}
