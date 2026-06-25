<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CommentRepliedNotification extends Notification
{
    use Queueable;

    protected $reply;
    protected $courseId;

    public function __construct($reply, $courseId)
    {
        $this->reply = $reply;
        $this->courseId = $courseId;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        return [
            'title' => 'New Reply to Your Comment',
            'message' => $this->reply->user->first_name . ' replied: "' . \Illuminate\Support\Str::limit($this->reply->body, 40) . '"',
            'url' => route('course.details', ['id' => $this->courseId]) . '#comment-' . $this->reply->id,
            'icon' => 'fa-reply',
            'color' => 'blue',
        ];
    }
}
