<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Permission;
use App\Containers\Authorization\Models\Role;
use App\Containers\Authorization\UI\API\Requests\AttachPermissionToRoleRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;

/**
 * Class AttachPermissionsToRoleAction.
 */
class AttachPermissionsToRoleAction extends Action
{
    public function run(AttachPermissionToRoleRequest $request): Role
    {
        /** @var Role $role */
        $role = Apiato::call('Authorization@FindRoleTask', [$request->role_id]);

        $permissionIds = $request->permissions_ids;

        $permissions = array_map(fn ($permissionId): ?Permission => Apiato::call('Authorization@FindPermissionTask', [$permissionId]), $permissionIds);

        return $role->givePermissionTo($permissions);
    }
}
