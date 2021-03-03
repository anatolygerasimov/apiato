<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Tasks;

use App\Ship\Parents\Tasks\Task;
use App\Ship\Parents\Transporters\Transporter;

class ExtractLoginCustomAttributeTask extends Task
{
    /**
     * @return array{username: mixed|null, login_attribute: array-key|null}
     */
    public function run(Transporter $data): array
    {
        $prefix             = config('authentication-container.login.prefix', '');
        $allowedLoginFields = config('authentication-container.login.attributes', ['email' => []]);

        $fields = array_keys((array)$allowedLoginFields);

        $loginUsername = null;
        // The original attribute that which the user tried to log in witch
        // eg 'email', 'username', 'phone'
        $loginAttribute = null;

        // Find first login custom attribute (allowed login field) found in request
        // eg: search the request exactly in order which they are in 'authentication-container'
        // for 'email' then 'phone' then 'username' in request
        // and put the first one found in 'username' field witch its value as 'username' value
        foreach ($fields as $field) {
            $fieldName      = $prefix . $field;
            $loginUsername  = $data->getInputByKey($fieldName);
            $loginAttribute = $field;

            if ($loginUsername !== null) {
                break;
            }
        }

        return [
            'username'        => $loginUsername,
            'login_attribute' => $loginAttribute,
        ];
    }
}
