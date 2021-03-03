<?php

namespace App\Containers\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class SyncUserRolesRequest.
 *
 * @property-read array $roles_ids
 * @property-read int $user_id
 */
class SyncUserRolesRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'roles'       => '',
        'permissions' => 'manage-admins-access',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'user_id',
        'roles_ids.*',
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
            'roles_ids'   => 'required',
            'roles_ids.*' => 'exists:roles,id',
            'user_id'     => 'required|exists:users,id',
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
