<?php

namespace App\Ship\Core\Abstracts\Notifications;

use Illuminate\Auth\Notifications\VerifyEmail as VerifyEmailLaravelNotification;

/**
 * Class VerifyEmail
 */
abstract class VerifyEmail extends VerifyEmailLaravelNotification
{
    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     *
     * @return array
     */
    public function via($notifiable)
    {
        return config('notification.channels');
    }
}
