<?php

namespace App\Containers\Authorization\Traits;

use App\Containers\User\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use Illuminate\Support\Facades\Auth;

/**
 * Class AuthorizationTrait.
 */
trait AuthorizationTrait
{
    /**
     * @return Authenticatable|null
     */
    public function getUser()
    {
        return Auth::user();
    }

    /**
     * @return bool
     */
    public function hasAdminRole()
    {
        return $this->hasRole('admin');
    }

    /**
     * @return bool
     */
    public function hasUserRole()
    {
        return $this->hasRole('user');
    }

    /**
     * Return the "highest" role of a user (0 if the user does not have any role).
     *
     * @return int
     */
    public function getRoleLevel()
    {
        /** @var MorphToMany $roles */
        $roles = $this->roles();

        return ($role = $roles->orderBy('level', 'desc')->first()) ? $role->level : 0;
    }
}
