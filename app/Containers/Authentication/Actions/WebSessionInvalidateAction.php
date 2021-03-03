<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\UI\WEB\Requests\LogoutRequest;
use App\Ship\Parents\Actions\Action;

/**
 * Class WebSessionInvalidateAction.
 */
class WebSessionInvalidateAction extends Action
{
    public function run(LogoutRequest $request): void
    {
        $request->session()->invalidate();

        $request->session()->regenerateToken();
    }
}
