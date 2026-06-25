<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="\favicon.ico">
    <title>All Notifications</title>
    <link rel="stylesheet" href="{{ asset('style/global.css') }}">
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('style/notifications.css') }}">
</head>

<body>
    <div class="container notif-list">
        <h1>All Notifications</h1>
        <p class="notif-meta">Viewing all notifications since you created your account.</p>

        @if ($notifications->count() === 0)
            <p>No notifications yet.</p>
        @else
            @foreach ($notifications as $notification)
                <div class="notif-item">
                    <div class="notif-avatar">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div class="notif-body">
                        @php
                            $data = $notification->data ?? [];
                            $message = $data['message'] ?? null;
                        @endphp
                        <div class="notif-content">
                            @if ($message)
                                <div class="notif-text">{!! nl2br(e($message)) !!}</div>
                            @else
                                <div class="notif-text">
                                    {{ is_array($data) ? json_encode($data, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) : (string) $data }}
                                </div>
                            @endif
                        </div>
                        <div class="notif-meta">
                            <span class="notif-time">{{ $notification->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                    <div class="notif-actions">
                        @if (is_null($notification->read_at))
                            <span class="badge-unread">Unread</span>
                        @else
                            <span class="badge-read">Read</span>
                        @endif
                    </div>
                </div>
            @endforeach

            <div style="margin-top:16px">{{ $notifications->links() }}</div>
        @endif

        <div style="margin-top:20px">
            <a href="{{ route('dashboard') }}">Back to dashboard</a>
        </div>
    </div>
</body>

</html>
