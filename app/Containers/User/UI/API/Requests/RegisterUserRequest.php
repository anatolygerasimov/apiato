<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class RegisterUserRequest.
 *
 * @property-read string $email
 * @property-read string $password
 * @property-read string $password_confirmation
 * @property-read string $username
 */
class RegisterUserRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'email'    => 'required|email|max:40|unique:users,email',
            'password' => 'required|min:6|max:30',
            'name'     => 'required|min:2|max:50',
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
