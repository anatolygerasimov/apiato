<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Events\Observers;

use App\Containers\User\Models\User;
use Illuminate\Support\Facades\Cache;

/**
 * Class UserObserver.
 */
class UserObserver
{
    /**
     * @return void
     */
    public function saved(User $user)
    {
        Cache::put("user.{$user->id}", $user, 60);
    }

    /**
     * @return void
     */
    public function deleted(User $user)
    {
        Cache::forget("user.{$user->id}");
    }

    /**
     * @return void
     */
    public function restored(User $user)
    {
        Cache::put("user.{$user->id}", $user, 60);
    }

    /**
     * @return void
     */
    public function retrieved(User $user)
    {
        Cache::add("user.{$user->id}", $user, 60);
    }
}
