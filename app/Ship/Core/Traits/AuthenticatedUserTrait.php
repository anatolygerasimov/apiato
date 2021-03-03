<?php

declare(strict_types=1);

namespace App\Ship\Core\Traits;

use App\Containers\User\Models\User;
use App\Ship\Core\Exceptions\AuthenticationUserException;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthenticatedUserTrait.
 *
 * @template T
 */
trait AuthenticatedUserTrait
{
    /**
     * @var T|null
     */
    private ?Authenticatable $user = null;

    /**
     * @return T
     */
    public function getStrictlyAuthUser(): Authenticatable
    {
        $user = $this->getAuthUser();

        if (empty($user)) {
            throw new AuthenticationUserException();
        }

        return $user;
    }

    public function getStrictlyAuthUserId(): int
    {
        $userId = $this->getAuthUserId();

        if (empty($userId)) {
            throw new AuthenticationUserException();
        }

        return $userId;
    }

    /**
     * @return User|null
     */
    public function getAuthUserModel()
    {
        return $this->getAuthUser();
    }

    /**
     * @return User
     */
    public function getStrictlyAuthUserModel()
    {
        return $this->getStrictlyAuthUser();
    }

    /**
     * @return T|null
     * @psalm-suppress MoreSpecificReturnType
     */
    public function getAuthUser(): ?Authenticatable
    {
        if (is_null($this->user)) {
            /** @psalm-suppress PropertyTypeCoercion */
            $this->user = Auth::user();
        }

        return $this->user;
    }

    public function getAuthUserId(): ?int
    {
        $user = $this->getAuthUser();

        return $user ? $this->getAuthIdentifierAsInt($user) : null;
    }

    /**
     * @param T $user
     */
    public function getAuthIdentifierAsInt(Authenticatable $user): int
    {
        return (int)$user->getAuthIdentifier();
    }

    /**
     * @param T $user
     */
    public function setAuthUser(Authenticatable $user): void
    {
        $this->user = $user;
    }
}
