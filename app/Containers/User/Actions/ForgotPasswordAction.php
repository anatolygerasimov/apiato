<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\UI\API\Requests\ForgotPasswordRequest;
use App\Ship\Parents\Actions\Action;
use Illuminate\Support\Facades\Password;

/**
 * Class ForgotPasswordAction.
 */
class ForgotPasswordAction extends Action
{
    public function run(ForgotPasswordRequest $forgotPasswordData): string
    {
        $input = $forgotPasswordData->sanitizeInput([
            'email',
        ]);

        $status = Password::broker()->sendResetLink($input);

        return (string)trans($status);
    }
}
