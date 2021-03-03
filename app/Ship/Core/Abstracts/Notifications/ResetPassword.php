<?php

namespace App\Ship\Core\Abstracts\Notifications;

use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordLaravelNotification;

/**
 * Class ResetPassword
 */
abstract class ResetPassword extends ResetPasswordLaravelNotification
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
