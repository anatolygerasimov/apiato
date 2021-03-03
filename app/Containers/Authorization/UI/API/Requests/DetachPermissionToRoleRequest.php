<?php

namespace App\Containers\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class DetachPermissionToRoleRequest.
 *
 * @property-read int   $role_id
 * @property-read array $permissions_ids
 */
class DetachPermissionToRoleRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'role_id',
        'permissions_ids.*',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [

    ];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'role_id'           => 'required|exists:roles,id',
            'permissions_ids'   => 'required',
            'permissions_ids.*' => 'exists:permissions,id',
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
