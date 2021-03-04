<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class CreateAdminRequest.
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read string $password_confirmation
 * @property-read string $username
 */
class CreateAdminRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => 'create-admins',
        'roles'       => '',
    ];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:6|max:30',
            'username' => 'required|min:2|max:100|unique:users,username',
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
