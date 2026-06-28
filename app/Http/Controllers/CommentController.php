<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use App\Notifications\AdminCommentReportedNotification;
use App\Notifications\CommentRepliedNotification;
use App\Notifications\CommentReportedNotification;
class CommentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $course = Course::findOrFail($courseId);

        $comment = Comment::create([
            'user_id'   => auth()->id(),
            'course_id' => $course->id,
            'parent_id' => $request->parent_id ?? null,
            'body'      => $request->body,
        ]);

        $comment->load('user', 'replies.user');

        if ($comment->parent_id) {
            $parentComment = Comment::with('user')->find($comment->parent_id);
            if ($parentComment && $parentComment->user_id !== auth()->id()) {
                $parentComment->user->notify(new CommentRepliedNotification($comment, $courseId));
            }
        }

        $user     = $comment->user;
        $initials = strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1));

        return response()->json([
            'success' => true,
            'comment' => [
                'id'         => $comment->id,
                'body'       => $comment->body,
                'parent_id'  => $comment->parent_id,
                'likes'      => 0,
                'liked'      => false,
                'created_at' => $comment->created_at->diffForHumans(),
                'user'       => [
                    'name'     => $user->first_name . ' ' . $user->last_name,
                    'initials' => $initials,
                ],
            ],
        ]);
    }

    public function toggleLike($id)
    {
        $comment = Comment::findOrFail($id);
        $userId  = auth()->id();

        $liked = $comment->likedByUsers()->where('user_id', $userId)->exists();

        if ($liked) {
            $comment->likedByUsers()->detach($userId);
            $comment->decrement('likes');
        } else {
            $comment->likedByUsers()->attach($userId);
            $comment->increment('likes');

            // Notify comment author if it's not the liker themselves
            if ($comment->user_id !== $userId && $comment->user) {
                $likerName = auth()->user()->first_name . ' ' . auth()->user()->last_name;
                $comment->user->notify(new \App\Notifications\CommentLikedNotification($comment, $likerName, $comment->course_id));
            }
        }

        return response()->json([
            'success' => true,
            'liked'   => !$liked,
            'likes'   => $comment->fresh()->likes,
        ]);
    }

    /**
     * Report a comment - sends notification to all admins.
     */
    public function report($id)
    {
        $comment      = Comment::with('course')->findOrFail($id);
        $reporterName = auth()->user()->first_name . ' ' . auth()->user()->last_name;

        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new AdminCommentReportedNotification(
                $reporterName,
                $comment->body,
                $comment->id,
                $comment->course_id
            ));
        }

        if ($comment->user) {
            $comment->user->notify(new CommentReportedNotification($comment));
        }

        return response()->json(['success' => true, 'message' => 'Comment reported successfully for review.']);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id !== auth()->id() && !auth()->user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['success' => true]);
    }
}
