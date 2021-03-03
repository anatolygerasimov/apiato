<?php

namespace App\Containers\Authorization\Actions;

use App\Containers\Authorization\Models\Permission;
use App\Ship\Core\Foundation\Facades\Apiato;
use App\Ship\Parents\Actions\Action;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class GetAllPermissionsAction.
 */
class GetAllPermissionsAction extends Action
{
    /**
     * @return Collection|array<array-key, Permission>
     */
    public function run()
    {
        return Apiato::call('Authorization@GetAllPermissionsTask', [], ['addRequestCriteria']);
    }
}
