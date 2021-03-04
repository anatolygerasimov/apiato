<?php

declare(strict_types=1);

namespace App\Containers\User\Actions;

use App\Containers\User\Exceptions\ResetPasswordException;
use App\Containers\User\Models\User;
use App\Containers\User\UI\API\Requests\ResetPasswordRequest;
use App\Ship\Exceptions\InternalErrorException;
use App\Ship\Parents\Actions\Action;
use App\Ship\Parents\Exceptions\Exception;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

/**
 * Class ResetPasswordAction.
 */
class ResetPasswordAction extends Action
{
    public function run(ResetPasswordRequest $resetPasswordData): string
    {
        $input = $resetPasswordData->sanitizeInput([
            'email',
            'token',
            'password',
            'password_confirmation',
        ]);

        try {
            $status = Password::broker()->reset(
                $input,
                function (User $user, string $password) {
                    $user->forceFill([
                        'password'       => Hash::make($password),
                        'remember_token' => Str::random(60),
                    ])->save();

                    event(new PasswordReset($user));
                }
            );
        } catch (Exception $e) {
            throw new InternalErrorException();
        }

        if ($status !== Password::PASSWORD_RESET) {
            throw new ResetPasswordException(trans($status));
        }

        return (string)trans($status);
    }
}
