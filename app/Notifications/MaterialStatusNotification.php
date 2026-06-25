<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class MaterialStatusNotification extends Notification
{
    use Queueable;

    protected $material;
    protected $status;

    public function __construct($material, $status)
    {
        $this->material = $material;
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
            'title' => 'Material ' . ucfirst($statusText),
            'message' => 'Your material "' . $this->material->title . '" has been ' . $statusText . '.',
            'url' => route('course.details', ['id' => $this->material->course_id]),
            'icon' => $this->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle',
            'color' => $this->status === 'approved' ? 'green' : 'red',
        ];
    }
}
