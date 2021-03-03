<?php

declare(strict_types=1);

namespace App\Containers\Authorization\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class GetAllRolesRequest.
 */
class GetAllRolesRequest extends Request
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
