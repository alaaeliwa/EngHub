<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AdminCommentReportedNotification extends Notification
{
    use Queueable;

    protected $reporterName;
    protected $commentBody;
    protected $commentId;
    protected $courseId;

    public function __construct($reporterName, $commentBody, $commentId, $courseId)
    {
        $this->reporterName = $reporterName;
        $this->commentBody  = $commentBody;
        $this->commentId    = $commentId;
        $this->courseId     = $courseId;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $preview = mb_substr($this->commentBody, 0, 60);
        if (mb_strlen($this->commentBody) > 60) {
            $preview .= '...';
        }

        return [
            'type'         => 'comment_reported',
            'title'        => 'Comment Reported',
            'message'      => "{$this->reporterName} reported a comment: \"{$preview}\"",
            'icon'         => 'fa-flag',
            'color'        => '#ef4444',
            'bg_color'     => 'rgba(239,68,68,0.1)',
            'comment_id'   => $this->commentId,
            'course_id'    => $this->courseId,
            'action_url'   => '/admin#comments',
        ];
    }
}
