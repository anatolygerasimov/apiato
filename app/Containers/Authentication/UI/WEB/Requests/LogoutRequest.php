<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\WEB\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class LogoutRequest.
 */
class LogoutRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
    ];

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

        ];
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess',
        ]);
    }
}
