<?php

declare(strict_types=1);

namespace App\Containers\Authentication\UI\WEB\Requests;

use App\Containers\Authentication\Data\Transporters\LoginTransporter;
use App\Ship\Parents\Requests\Request;
use Illuminate\Support\Arr;

/**
 * Class LoginRequest.
 */
class LoginRequest extends Request
{
    /**
     * The assigned Transporter for this Request.
     *
     * @var string
     */
    protected $transporter = LoginTransporter::class;

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
        $prefix             = config('authentication-container.login.prefix', '');
        $allowedLoginFields = config('authentication-container.login.attributes', ['email' => []]);

        $rules = [
            'password' => 'required|string',
        ];

        foreach ((array)$allowedLoginFields as $key => $optionalValidators) {
            // build all other login fields together
            $allOtherLoginFields = Arr::except($allowedLoginFields, $key);
            $allOtherLoginFields = array_keys($allOtherLoginFields);
            $allOtherLoginFields = preg_filter('/^/', $prefix, $allOtherLoginFields);
            $allOtherLoginFields = implode(',', $allOtherLoginFields);

            $validators = implode('|', $optionalValidators);

            $keyName = $prefix . $key;

            $rules = array_merge($rules,
                [
                    $keyName => "required_without_all:{$allOtherLoginFields}|exists:users,{$key}|{$validators}",
                ]);
        }

        return $rules;
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
