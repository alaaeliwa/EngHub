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
            'title' => __('messages.comment_reply_title'),
            'message' => __('messages.comment_reply_message', [
                'name' => $this->reply->user->first_name,
                'comment' => \Illuminate\Support\Str::limit($this->reply->body, 40)
            ]),
            'url' => route('course.details', ['id' => $this->courseId]) . '#comment-' . $this->reply->id,
            'icon' => 'fa-reply',
            'color' => '#3b82f6',
            'bg_color' => 'rgba(59,130,246,0.1)',
        ];
    }
}
