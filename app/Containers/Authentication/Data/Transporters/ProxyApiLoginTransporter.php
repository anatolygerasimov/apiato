<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

/**
 * Class ProxyApiLoginTransporter.
 *
 * @property-read string $client_ip
 * @property-read string $password
 * @property-read string $grant_type
 * @property-read string $client_id
 * @property-read string $client_password
 * @property-read string $scope
 */
class ProxyApiLoginTransporter extends Transporter
{
    protected $schema = [
        'type'       => 'object',
        'properties' => [
            'email',
            'username',
            'password',
            'client_id',
            'client_password',
            'grant_type',
            'scope',
        ],
        'required'   => [
            'password',
            'client_id',
            'client_password',
        ],
        'default'    => [
            'scope'      => '',
            'grant_type' => 'password',
        ],
    ];
}
