<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Auth;

/**
 * Class WebLogoutAction.
 */
class WebLogoutAction extends Action
{
    public function run(): void
    {
        Auth::logout();
    }
}
