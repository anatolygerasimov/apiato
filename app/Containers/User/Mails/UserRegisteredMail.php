<?php

declare(strict_types=1);

namespace App\Containers\User\Mails;

use App\Containers\User\Models\User;
use App\Ship\Parents\Mails\Mail;
use App\Ship\Parents\Notifications\Messages\MailMessage;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Lang;

class UserRegisteredMail extends Mail implements ShouldQueue
{
    use Queueable;

    protected User $user;

    /**
     * UserRegisteredNotification constructor.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * @return $this
     */
    public function build()
    {
        $view = (new MailMessage())
            ->greeting("Welcome {$this->user->username}!")
            ->subject(Lang::get('Welcome'))
            ->line(Lang::get('Thank you for signing up.'))
            ->render();

        return $this->html($view)->to(
            $this->user->email,
            $this->user->username
        );
    }
}
