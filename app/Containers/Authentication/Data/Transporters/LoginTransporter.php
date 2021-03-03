<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

/**
 * Class LoginTransporter.
 *
 * @property-read string $email
 * @property-read string $username
 * @property-read string $password
 * @property-read string $login_attribute
 * @property-read bool $remember_me
 */
class LoginTransporter extends Transporter
{
    protected $schema = [
        'type'       => 'object',
        'properties' => [
            'email'           => ['type' => 'string'],
            'username'        => ['type' => 'string'],
            'password'        => ['type' => 'string'],
            'login_attribute' => ['type' => 'string'],
            'remember_me'     => ['type' => 'boolean'],
        ],
        'required'   => [
            'password',
        ],
        'default'    => [
            'login_attribute' => 'email',
            'remember_me'     => false,
        ],
    ];
}
