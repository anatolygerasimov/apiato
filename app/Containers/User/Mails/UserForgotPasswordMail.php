<?php

declare(strict_types=1);

namespace App\Containers\User\Mails;

use App\Containers\User\Models\User;
use App\Ship\Parents\Mails\Mail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * Class UserForgotPasswordMail.
 */
class UserForgotPasswordMail extends Mail implements ShouldQueue
{
    use Queueable;

    protected User $recipient;

    protected string $token;

    protected string $resetUrl;

    public function __construct(User $recipient, string $token, string $resetUrl)
    {
        $this->recipient = $recipient;
        $this->token     = $token;
        $this->resetUrl  = $resetUrl;
    }

    /**
     * @return $this
     */
    public function build()
    {
        return $this->view('user::user-forgotPassword', [
            'token'    => $this->token,
            'resetUrl' => $this->resetUrl,
            'email'    => $this->recipient->email,
        ])->to(
            $this->recipient->email,
            $this->recipient->username
        );
    }
}
