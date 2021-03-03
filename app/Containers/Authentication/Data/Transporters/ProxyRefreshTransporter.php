<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Data\Transporters;

use App\Ship\Parents\Transporters\Transporter;

/**
 * Class ProxyRefreshTransporter.
 *
 * @property-read string $refresh_token
 * @property-read int $client_id
 * @property-read string $client_password
 * @property-read string $grant_type
 * @property-read string $scope
 */
class ProxyRefreshTransporter extends Transporter
{
    protected $schema = [
        'type'       => 'object',
        'properties' => [
            'refresh_token',
            'client_id',
            'client_password',
            'grant_type',
            'scope',
        ],
        'required'   => [
            'refresh_token',
            'client_id',
            'client_password',
        ],
        'default'    => [
            'scope'      => '',
            'grant_type' => 'refresh_token',
        ],
    ];
}
