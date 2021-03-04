<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Requests;

use App\Ship\Parents\Requests\Request;
use Illuminate\Validation\Rule;

/**
 * Class UpdateUserRequest.
 *
 * @property-read int    $id
 * @property string      $password
 * @property-read string $password_confirmation
 * @property-read string $username
 * @property-read string $first_name
 * @property-read string $last_name
 * @property-read string $avatar
 * @property-read string $company_name
 * @property-read string $data_source
 */
class UpdateUserRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'permissions' => '',
        'roles'       => '',
    ];

    /**
     * Id's that needs decoding before applying the validation rules.
     */
    protected array $decode = [
        'id',
    ];

    /**
     * Defining the URL parameters (`/stores/999/items`) allows applying
     * validation rules on them and allows accessing them like request data.
     */
    protected array $urlParameters = [
        'id',
    ];

    /**
     * @return array
     */
    public function rules()
    {
        return [
            'id'           => 'required|exists:users,id',
            'username'     => 'string|min:2|max:100|unique:users,username',
            'first_name'   => 'string|min:2|max:100',
            'last_name'    => 'string|min:2|max:100',
            'avatar'       => 'url',
            'company_name' => 'string|min:2|max:100',
            'data_source'  => Rule::in(array_keys(config('init-container.data_sources'))),
        ];
    }

    /**
     * Is this an admin who has access to permission `update-users`
     * or the user is updating his own object (is the owner).
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->check([
            'hasAccess|isOwner',
        ]);
    }
}
