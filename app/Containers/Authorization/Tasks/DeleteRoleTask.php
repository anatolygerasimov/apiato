<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Data\Repositories\RoleRepository;
use App\Containers\Authorization\Models\Role;
use App\Ship\Exceptions\DeleteResourceFailedException;
use App\Ship\Parents\Tasks\Task;
use Exception;

/**
 * Class DeleteRoleTask.
 */
class DeleteRoleTask extends Task
{
    protected RoleRepository $repository;

    public function __construct(RoleRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param int|Role $role
     *
     * @throws DeleteResourceFailedException
     */
    public function run($role): bool
    {
        if ($role instanceof Role) {
            $role = $role->id;
        }

        // delete the record from the roles table.
        try {
            return (bool)$this->repository->delete($role);
        } catch (Exception $exception) {
            throw new DeleteResourceFailedException();
        }
    }
}
