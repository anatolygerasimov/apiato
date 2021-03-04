<?php

declare(strict_types=1);

namespace App\Containers\User\UI\API\Transformers;

use App\Containers\Authorization\UI\API\Transformers\RoleTransformer;
use App\Containers\User\Models\User;
use App\Ship\Parents\Transformers\Transformer;
use Illuminate\Support\Carbon;
use League\Fractal\Resource\Collection;

/**
 * Class UserTransformer.
 */
class UserTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes = [
        'roles',
    ];

    public function transform(User $user): array
    {
        /** @var Carbon|null $updateAt */
        $updateAt = $user->updated_at;

        return [
            'object'              => 'User',
            'id'                  => $user->getHashedKey(),
            'username'            => $user->username,
            'email'               => $user->email,
            'avatar'              => $user->avatar_url,
            'default_process_id'  => $user->getHashedKey('default_process_id'),
            'default_screen_id'   => $user->getHashedKey('default_screen_id'),
            'company_id'          => $user->getHashedKey('company_id'),
            'first_name'          => $user->first_name,
            'last_name'           => $user->last_name,
            'data_source'         => $user->data_source,
            'is_client'           => $user->is_client,
            'is_email_confirmed'  => $user->hasVerifiedEmail(),
            'updated_at'          => $updateAt,
            'readable_updated_at' => $updateAt ? $updateAt->diffForHumans() : null,
        ];
    }

    /**
     * @return Collection
     */
    public function includeRoles(User $user)
    {
        return $this->collection($user->roles, new RoleTransformer());
    }
}
