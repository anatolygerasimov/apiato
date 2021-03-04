<?php

namespace App\Containers\Payment\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class UpdatePaymentAccountRequest.
 *
 * @property-read int         $id
 * @property-read string|null $name
 */
class UpdatePaymentAccountRequest extends Request
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
     * Defining the URL parameters (e.g, `/user/{id}`) allows applying
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
            // put your rules here
            'id'   => 'required|exists:payment_accounts,id',
            'name' => 'sometimes|string|max:190',
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
