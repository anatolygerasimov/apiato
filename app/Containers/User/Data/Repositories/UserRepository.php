<?php

declare(strict_types=1);

namespace App\Containers\User\Data\Repositories;

use App\Containers\User\Contracts\UserRepositoryInterface;
use App\Containers\User\Models\User;
use App\Ship\Parents\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Class UserRepository.
 */
class UserRepository extends Repository implements UserRepositoryInterface
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'id'       => '=',
        'email'    => '=',
        'username' => 'like',
    ];

    /**
     * The cache is updated via UserObserver.
     * We use a relation call 'user', because the above entity can be called from eager loaded 'with'.
     */
    public function getRememberUser(Model $entity): ?User
    {
        return Cache::remember(
                "user.{$entity->user_id}", 60,
                /** @return User|null */
                fn () => $entity->user
            );
    }
}
