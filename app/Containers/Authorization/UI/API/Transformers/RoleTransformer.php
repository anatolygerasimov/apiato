<?php

namespace App\Containers\Authorization\UI\API\Transformers;

use App\Containers\Authorization\Models\Role;
use App\Ship\Parents\Transformers\Transformer;
use League\Fractal\Resource\Collection;

/**
 * Class RoleTransformer.
 */
class RoleTransformer extends Transformer
{
    /**
     * @var string[]
     */
    protected $defaultIncludes = [
        'permissions',
    ];

    public function transform(Role $role): array
    {
        return [
            'object'       => 'Role',
            'id'           => $role->getHashedKey(), // << Unique Identifier
            'name'         => $role->name, // << Unique Identifier
            'description'  => $role->description,
            'display_name' => $role->display_name,
            'level'        => $role->level,
        ];
    }

    /**
     * @return Collection
     */
    public function includePermissions(Role $role)
    {
        return $this->collection($role->permissions, new PermissionTransformer());
    }
}
