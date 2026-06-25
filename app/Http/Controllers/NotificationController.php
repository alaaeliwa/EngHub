<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display all notifications for the logged-in user.
     * Admins get redirected to the admin-specific notifications page.
     */
    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->role === 'admin') {
            return $this->adminIndex($request);
        }

        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(20);

        return view('notifications.index', compact('notifications'));
    }

    /**
     * Admin-specific notifications page.
     */
    public function adminIndex(Request $request)
    {
        $user          = Auth::user();
        $notifications = $user->notifications()->orderBy('created_at', 'desc')->paginate(30);

        return view('notifications.admin', compact('notifications'));
    }

    /**
     * Mark a single notification as read and redirect to action_url.
     */
    public function markAsRead($id)
    {
        $user         = Auth::user();
        $notification = $user->notifications()->where('id', $id)->firstOrFail();
        $notification->markAsRead();

        $actionUrl = $notification->data['url'] ?? $notification->data['action_url'] ?? '/';

        return redirect($actionUrl);
    }

    /**
     * Mark all notifications as read (AJAX).
     */
    public function markAllAsRead(Request $request)
    {
        Auth::user()->unreadNotifications->markAsRead();

        return response()->json(['success' => true]);
    }

    /**
     * Return unread admin notifications as JSON for the bell dropdown.
     */
    public function adminJson()
    {
        $user          = Auth::user();
        $notifications = $user->notifications()
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get()
            ->map(function ($n) {
                return [
                    'id'         => $n->id,
                    'type'       => $n->data['type']      ?? 'general',
                    'title'      => $n->data['title']     ?? 'Notification',
                    'message'    => $n->data['message']   ?? '',
                    'icon'       => $n->data['icon']      ?? 'fa-bell',
                    'color'      => $n->data['color']     ?? '#6366f1',
                    'bg_color'   => $n->data['bg_color']  ?? 'rgba(99,102,241,0.1)',
                    'action_url' => $n->data['action_url'] ?? '/admin',
                    'is_unread'  => is_null($n->read_at),
                    'time'       => $n->created_at->diffForHumans(),
                    'read_url'   => route('notifications.read', $n->id),
                ];
            });

        $unreadCount = $user->unreadNotifications()->count();

        return response()->json([
            'notifications' => $notifications,
            'unread_count'  => $unreadCount,
        ]);
    }
}
