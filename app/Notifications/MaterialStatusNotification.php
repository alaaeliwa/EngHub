<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MaterialStatusNotification extends Notification
{
    use Queueable;

    protected $materialTitle;
    protected $status;

    /**
     * Create a new notification instance.
     */
    public function __construct($materialTitle, $status)
    {
        $this->materialTitle = $materialTitle;
        $this->status = $status;
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
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = "";
        if ($this->status === 'approved') {
            $message = "تمت الموافقة على الملف: {$this->materialTitle}";
        } elseif ($this->status === 'rejected') {
            $message = "تم رفض الملف: {$this->materialTitle}";
        } elseif ($this->status === 'deleted') {
            $message = "تم حذف الملف: {$this->materialTitle}";
        }

        return [
            'title' => 'تحديث حالة الملف',
            'message' => $message,
            'status' => $this->status,
            'icon' => 'fa-file'
        ];
    }
}
