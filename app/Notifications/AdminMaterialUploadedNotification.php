<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminMaterialUploadedNotification extends Notification
{
    use Queueable;

    protected $uploaderName;
    protected $materialTitle;
    protected $materialId;

    public function __construct($uploaderName, $materialTitle, $materialId)
    {
        $this->uploaderName  = $uploaderName;
        $this->materialTitle = $materialTitle;
        $this->materialId    = $materialId;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'           => 'material_uploaded',
            'title'          => 'New Material Pending Review',
            'message'        => "{$this->uploaderName} uploaded a material: \"{$this->materialTitle}\" and it requires approval or rejection.",
            'icon'           => 'fa-cloud-arrow-up',
            'color'          => '#3b82f6',
            'bg_color'       => 'rgba(59,130,246,0.1)',
            'material_id'    => $this->materialId,
            'action_url'     => '/admin#materials',
        ];
    }
}
