<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class ResetPasswordRequest.
 *
 * @property-read string $token
 * @property-read string $email
 * @property-read string $password
 * @property-read string $password_confirmation
 */
class ResetPasswordRequest extends Request
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
            'token'    => 'required|max:255',
            'email'    => 'required|email|max:255',
            'password' => 'required|string|confirmed|min:6|max:30',
        ];
    }

    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
