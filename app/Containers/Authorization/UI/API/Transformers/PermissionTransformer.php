<?php

namespace App\Containers\Authorization\UI\API\Transformers;

use App\Containers\Authorization\Models\Permission;
use App\Ship\Parents\Transformers\Transformer;

/**
 * Class PermissionTransformer.
 */
class PermissionTransformer extends Transformer
{
    /**
     * @var mixed[]
     */
    protected $availableIncludes = [

    ];

    /**
     * @var mixed[]
     */
    protected $defaultIncludes = [

    ];

    /**
     * @return array
     */
    public function transform(Permission $permission)
    {
        return [
            'object'       => 'Permission',
            'id'           => $permission->getHashedKey(), // << Unique Identifier
            'name'         => $permission->name, // << Unique Identifier
            'description'  => $permission->description,
            'display_name' => $permission->display_name,
        ];
    }
}
