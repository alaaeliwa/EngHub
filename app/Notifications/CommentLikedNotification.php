<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CommentLikedNotification extends Notification
{
    use Queueable;

    protected $comment;
    protected $likerName;
    protected $courseId;

    public function __construct($comment, $likerName, $courseId)
    {
        $this->comment = $comment;
        $this->likerName = $likerName;
        $this->courseId = $courseId;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => __('messages.comment_like_title'),
            'message' => __('messages.comment_like_message', [
                'name' => $this->likerName,
                'comment' => \Illuminate\Support\Str::limit($this->comment->body, 40)
            ]),
            'url' => route('course.details', ['id' => $this->courseId]) . '#comment-' . $this->comment->id,
            'icon' => 'fa-heart',
            'color' => '#ef4444',
            'bg_color' => 'rgba(239,68,68,0.1)',
        ];
    }
}
