<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkshopRegisteredNotification extends Notification
{
    use Queueable;

    protected $workshop;

    /**
     * Create a new notification instance.
     */
    public function __construct($workshop)
    {
        $this->workshop = $workshop;
    }

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'تم قبول تسجيلك في ورشة العمل!',
            'message' => 'لقد تم تسجيلك بنجاح في ورشة العمل: ' . $this->workshop->title,
            'icon' => 'fa-check-circle',
            'color' => '#10b981',
            'bg_color' => 'rgba(16, 185, 129, 0.1)'
        ];
    }
}
