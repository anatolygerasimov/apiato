<?php

declare(strict_types=1);

namespace App\Containers\Authorization\UI\API\Controllers;

use App\Containers\Authorization\UI\API\Requests\AssignUserToRoleRequest;
use App\Containers\Authorization\UI\API\Requests\AttachPermissionToRoleRequest;
use App\Containers\Authorization\UI\API\Requests\CreatePermissionRequest;
use App\Containers\Authorization\UI\API\Requests\CreateRoleRequest;
use App\Containers\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Containers\Authorization\UI\API\Requests\DetachPermissionToRoleRequest;
use App\Containers\Authorization\UI\API\Requests\FindPermissionRequest;
use App\Containers\Authorization\UI\API\Requests\FindRoleRequest;
use App\Containers\Authorization\UI\API\Requests\GetAllPermissionsRequest;
use App\Containers\Authorization\UI\API\Requests\GetAllRolesRequest;
use App\Containers\Authorization\UI\API\Requests\RevokeUserFromRoleRequest;
use App\Containers\Authorization\UI\API\Requests\SyncPermissionsOnRoleRequest;
use App\Containers\Authorization\UI\API\Requests\SyncUserRolesRequest;
use App\Containers\Authorization\UI\API\Transformers\PermissionTransformer;
use App\Containers\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\User\UI\API\Transformers\UserTransformer;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Controllers\ApiController;
use Illuminate\Http\JsonResponse;

/**
 * Class Controller.
 */
class Controller extends ApiController
{
    /**
     * @return array
     */
    public function getAllPermissions(GetAllPermissionsRequest $request)
    {
        $permissions = Apiato::call('Authorization@GetAllPermissionsAction');

        return $this->transform($permissions, PermissionTransformer::class);
    }

    /**
     * @return array
     */
    public function findPermission(FindPermissionRequest $request)
    {
        $permission = Apiato::call('Authorization@FindPermissionAction', [$request]);

        return $this->transform($permission, PermissionTransformer::class);
    }

    /**
     * @return array
     */
    public function getAllRoles(GetAllRolesRequest $request)
    {
        $roles = Apiato::call('Authorization@GetAllRolesAction');

        return $this->transform($roles, RoleTransformer::class);
    }

    /**
     * @return array
     */
    public function findRole(FindRoleRequest $request)
    {
        $role = Apiato::call('Authorization@FindRoleAction', [$request]);

        return $this->transform($role, RoleTransformer::class);
    }

    /**
     * @return array
     */
    public function assignUserToRole(AssignUserToRoleRequest $request)
    {
        $user = Apiato::call('Authorization@AssignUserToRoleAction', [$request]);

        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @return array
     */
    public function syncUserRoles(SyncUserRolesRequest $request)
    {
        $user = Apiato::call('Authorization@SyncUserRolesAction', [$request]);

        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @return JsonResponse
     */
    public function deleteRole(DeleteRoleRequest $request)
    {
        Apiato::call('Authorization@DeleteRoleAction', [$request]);

        return $this->noContent();
    }

    /**
     * @return array
     */
    public function revokeRoleFromUser(RevokeUserFromRoleRequest $request)
    {
        $user = Apiato::call('Authorization@RevokeUserFromRoleAction', [$request]);

        return $this->transform($user, UserTransformer::class);
    }

    /**
     * @return array
     */
    public function attachPermissionToRole(AttachPermissionToRoleRequest $request)
    {
        $role = Apiato::call('Authorization@AttachPermissionsToRoleAction', [$request]);

        return $this->transform($role, RoleTransformer::class);
    }

    /**
     * @return array
     */
    public function syncPermissionOnRole(SyncPermissionsOnRoleRequest $request)
    {
        $role = Apiato::call('Authorization@SyncPermissionsOnRoleAction', [$request]);

        return $this->transform($role, RoleTransformer::class);
    }

    /**
     * @return array
     */
    public function detachPermissionFromRole(DetachPermissionToRoleRequest $request)
    {
        $role = Apiato::call('Authorization@DetachPermissionsFromRoleAction', [$request]);

        return $this->transform($role, RoleTransformer::class);
    }

    /**
     * @return array
     */
    public function createRole(CreateRoleRequest $request)
    {
        $role = Apiato::call('Authorization@CreateRoleAction', [$request]);

        return $this->transform($role, RoleTransformer::class);
    }

    /**
     * @return array
     */
    public function createPermission(CreatePermissionRequest $request)
    {
        $permission = Apiato::call('Authorization@CreatePermissionAction', [$request]);

        return $this->transform($permission, PermissionTransformer::class);
    }
}
