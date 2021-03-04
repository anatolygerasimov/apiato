<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Providers;

use App\Containers\User\Models\User;
use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Support\Facades\Cache;

/**
 * Class CacheUserProvider.
 */
class CacheUserProvider extends EloquentUserProvider
{
  /**
   * Create a new database user provider.
   *
   * @param HasherContract $hasher
   */
    public function __construct(HasherContract $hasher)
    {
        parent::__construct($hasher, User::class);
    }

  /**
   * Retrieve a user by their unique identifier.
   *
   * @param string $identifier
   * @return Authenticatable|null
   * @psalm-suppress MoreSpecificImplementedParamType
   *
   */
    public function retrieveById($identifier): ?Authenticatable
    {
        return Cache::get("user.$identifier") ?? parent::retrieveById($identifier);
    }
}
