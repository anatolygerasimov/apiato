<?php

declare(strict_types=1);

namespace App\Containers\Authentication\Actions;

use App\Containers\Authentication\UI\WEB\Requests\LoginRequest;
use App\Ship\Parents\Actions\Action;

/**
 * Class WebSessionRegenerateAction.
 */
class WebSessionRegenerateAction extends Action
{
    public function run(LoginRequest $request): void
    {
        $request->session()->regenerate();
    }
}
