<?php

namespace App\Containers\Authorization\Tasks;

use App\Containers\Authorization\Models\Role;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Tasks\Task;

/**
 * Class DetachPermissionsFromRoleTask.
 */
class DetachPermissionsFromRoleTask extends Task
{
    /**
     * @param mixed|array $singleOrMultiplePermissionIds
     */
    public function run(Role $role, array $singleOrMultiplePermissionIds): Role
    {
        if (!is_array($singleOrMultiplePermissionIds)) {
            $singleOrMultiplePermissionIds = [$singleOrMultiplePermissionIds];
        }

        // remove each permission ID found in the array from that role.
        array_map(function ($permissionId) use ($role) {
            $permission = Apiato::call('Authorization@FindPermissionTask', [$permissionId]);
            $role->revokePermissionTo($permission);
        }, $singleOrMultiplePermissionIds);

        return $role;
    }
}
