<?php

namespace App\Ship\Core\Abstracts\Notifications;

use Illuminate\Notifications\Notification as LaravelNotification;

/**
 * Class Notification
 */
abstract class Notification extends LaravelNotification
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
