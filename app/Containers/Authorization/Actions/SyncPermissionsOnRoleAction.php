<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\SyncPermissionsOnRoleRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class SyncPermissionsOnRoleAction.
 */
class SyncPermissionsOnRoleAction extends Action
{
    public function run(SyncPermissionsOnRoleRequest $request): Role
    {
        $role = Apiato::call('Authorization@FindRoleTask', [$request->role_id]);

        $permissionsIds = $request->permissions_ids;

        $permissions = array_map(fn ($permissionId): ?Permission => Apiato::call('Authorization@FindPermissionTask', [$permissionId]), $permissionsIds);

        $role->syncPermissions($permissions);

        return $role;
    }
}
