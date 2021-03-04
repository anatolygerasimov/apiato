<?php

namespace App\Containers\Stripe\UI\API\Requests;

use App\Ship\Parents\Requests\Request;

/**
 * Class UpdateStripeAccountRequest.
 *
 * @property-read int    $id
 * @property-read string $customer_id
 * @property-read string $card_id
 * @property-read string $card_funding
 * @property-read int    $card_last_digits
 * @property-read string $card_fingerprint
 */
class UpdateStripeAccountRequest extends Request
{
    /**
     * Define which Roles and/or Permissions has access to this request.
     */
    protected array $access = [
        'roles'       => '',
        'permissions' => '',
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
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id'               => 'required|exists:stripe_accounts,id',
            'customer_id'      => 'sometimes|min:3',
            'card_id'          => 'sometimes|min:3',
            'card_funding'     => 'sometimes',
            'card_last_digits' => 'sometimes|integer|min:0|max:9999',
            'card_fingerprint' => 'sometimes|string',
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
