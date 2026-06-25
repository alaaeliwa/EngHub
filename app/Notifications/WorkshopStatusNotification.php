<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class WorkshopStatusNotification extends Notification
{
    use Queueable;

    protected $workshop;
    protected $status;

    public function __construct($workshop, $status)
    {
        $this->workshop = $workshop;
        $this->status = $status;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $statusText = $this->status === 'approved' ? 'approved' : 'rejected';
        return [
            'title' => 'Workshop ' . ucfirst($statusText),
            'message' => 'Your workshop "' . $this->workshop->title . '" has been ' . $statusText . '.',
            'url' => $this->status === 'approved' ? route('workshop-details', ['id' => $this->workshop->id]) : '#',
            'icon' => $this->status === 'approved' ? 'fa-calendar-check' : 'fa-calendar-xmark',
            'color' => $this->status === 'approved' ? 'green' : 'red',
        ];
    }
}
