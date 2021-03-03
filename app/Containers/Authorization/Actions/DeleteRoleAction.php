<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\UI\API\Requests\DeleteRoleRequest;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Spatie\Permission\Contracts\Role;

/**
 * Class DeleteRoleAction.
 */
class DeleteRoleAction extends Action
{
    public function run(DeleteRoleRequest $request): Role
    {
        $role = Apiato::call('Authorization@FindRoleTask', [$request->id]);

        Apiato::call('Authorization@DeleteRoleTask', [$role]);

        return $role;
    }
}
