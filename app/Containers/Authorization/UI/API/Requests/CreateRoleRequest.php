<?php

namespace App\Containers\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class CreateRoleRequest.
 *
 * @property-read string      $name
 * @property-read string      $description
 * @property-read string      $display_name
 * @property-read int|null    $level
 * @property-read string|null $guard_name
 */
class CreateRoleRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'roles'       => '',
        'permissions' => 'manage-roles',
    ];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'name'         => 'required|unique:roles,name|min:2|max:20|no_spaces',
            'description'  => 'max:255',
            'display_name' => 'max:100',
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
