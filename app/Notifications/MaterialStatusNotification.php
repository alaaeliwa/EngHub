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
        $statusText = $this->status === 'approved' ? __('messages.approved') : __('messages.rejected');
        
        return [
            'title' => __('messages.material_status_title', ['status' => $statusText]),
            'message' => __('messages.material_status_message', ['title' => $this->material->title, 'status' => $statusText]),
            'icon' => $this->status === 'approved' ? 'fa-check-circle' : 'fa-times-circle',
            'color' => $this->status === 'approved' ? '#059669' : '#dc2626',
            'bg_color' => $this->status === 'approved' ? 'rgba(5,150,105,0.1)' : 'rgba(220,38,38,0.1)'
        ];
    }
}
