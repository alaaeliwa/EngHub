<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Course;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $courseId)
    {
        $request->validate([
            'body' => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $course = Course::findOrFail($courseId);

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'course_id' => $course->id,
            'parent_id' => $request->parent_id ?? null,
            'body' => $request->body,
        ]);

        $comment->load('user', 'replies.user');

        $user = $comment->user;
        $initials = strtoupper(substr($user->first_name, 0, 1) . substr($user->last_name, 0, 1));

        return response()->json([
            'success' => true,
            'comment' => [
                'id' => $comment->id,
                'body' => $comment->body,
                'parent_id' => $comment->parent_id,
                'likes' => 0,
                'liked' => false,
                'created_at' => $comment->created_at->diffForHumans(),
                'user' => [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'initials' => $initials,
                ],
            ],
        ]);
    }

    public function toggleLike($id)
    {
        $comment = Comment::findOrFail($id);
        $userId = auth()->id();

        $liked = $comment->likedByUsers()->where('user_id', $userId)->exists();

        if ($liked) {
            $comment->likedByUsers()->detach($userId);
            $comment->decrement('likes');
        } else {
            $comment->likedByUsers()->attach($userId);
            $comment->increment('likes');
        }

        return response()->json([
            'success' => true,
            'liked' => !$liked,
            'likes' => $comment->fresh()->likes,
        ]);
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
