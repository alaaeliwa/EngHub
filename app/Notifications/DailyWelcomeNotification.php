<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class DailyWelcomeNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => __('messages.daily_welcome_title'),
            'message' => __('messages.daily_welcome_message'),
            'url' => route('dashboard'),
            'icon' => 'fa-rocket',
            'color' => '#6366f1',
            'bg_color' => 'rgba(99,102,241,0.1)',
        ];
    }
}
