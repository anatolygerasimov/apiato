<?php

namespace App\Containers\Authorization\Data\Repositories;

use App\Ship\Parents\Repositories\Repository;

/**
 * Class PermissionRepository.
 */
class PermissionRepository extends Repository
{
    /**
     * The container name. Must be set when the model has different name than the container.
     */
    protected string $container = 'Authorization';

    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'         => '=',
        'display_name' => 'like',
        'description'  => 'like',
    ];
}
