<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentReportedNotification extends Notification
{
    use Queueable;

    protected $comment;

    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'Comment Reported',
            'message' => 'Your comment "' . \Illuminate\Support\Str::limit($this->comment->body, 40) . '" has been reported and is under review.',
            'url' => route('course.details', ['id' => $this->comment->course_id]) . '#comment-' . $this->comment->id,
            'icon' => 'fa-flag',
            'color' => 'orange',
        ];
    }
}
