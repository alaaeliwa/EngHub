<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminWorkshopCreatedNotification extends Notification
{
    use Queueable;

    protected $creatorName;
    protected $workshopTitle;
    protected $workshopId;

    public function __construct($creatorName, $workshopTitle, $workshopId)
    {
        $this->creatorName    = $creatorName;
        $this->workshopTitle  = $workshopTitle;
        $this->workshopId     = $workshopId;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'         => 'workshop_created',
            'title'        => 'New Workshop Pending Review',
            'message'      => "{$this->creatorName} created a new workshop: \"{$this->workshopTitle}\" and it requires approval.",
            'icon'         => 'fa-calendar-plus',
            'color'        => '#f59e0b',
            'bg_color'     => 'rgba(245,158,11,0.1)',
            'workshop_id'  => $this->workshopId,
            'action_url'   => '/admin#workshops',
        ];
    }
}
