<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Admin Notifications - EngHub">
    <link rel="icon" href="/favicon.ico">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/global.css') }}">
    <link rel="stylesheet" href="{{ asset('style/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('style/notifications.css') }}">
    <title>Notifications | Admin EngHub</title>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #f1f5f9; min-height: 100vh; direction: ltr; }

        /* ── Top Bar ── */
        .an-topbar {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            padding: 0 32px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 100;
            box-shadow: 0 2px 16px rgba(0,0,0,.25);
        }
        .an-topbar-left { display: flex; align-items: center; gap: 16px; }
        .an-back-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255,255,255,.08);
            border: 1px solid rgba(255,255,255,.12);
            color: #e2e8f0;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: .85rem;
            font-weight: 500;
            transition: background .2s, border-color .2s;
        }
        .an-back-btn:hover { background: rgba(255,255,255,.15); border-color: rgba(255,255,255,.25); color: #fff; }
        .an-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
        .an-logo img { height: 34px; }
        .an-logo-tag {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            color: #fff;
            font-size: .68rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 4px;
            letter-spacing: 1px;
        }
        .an-topbar-right { display: flex; align-items: center; gap: 12px; }
        .an-mark-all {
            background: rgba(99,102,241,.15);
            border: 1px solid rgba(99,102,241,.3);
            color: #a5b4fc;
            padding: 7px 14px;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 500;
            cursor: pointer;
            transition: all .2s;
        }
        .an-mark-all:hover { background: rgba(99,102,241,.3); color: #c7d2fe; }

        /* ── Page Content ── */
        .an-page { max-width: 820px; margin: 0 auto; padding: 36px 20px 60px; }

        .an-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 28px;
            flex-wrap: wrap;
            gap: 12px;
        }
        .an-title-block h1 {
            font-size: 1.6rem;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .an-title-block p { color: #64748b; font-size: .875rem; }

        /* Badge counts */
        .an-counts { display: flex; gap: 10px; flex-wrap: wrap; }
        .an-count-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            border-radius: 999px;
            font-size: .78rem;
            font-weight: 600;
        }
        .an-count-chip.all    { background: #e0e7ff; color: #4338ca; }
        .an-count-chip.unread { background: #fee2e2; color: #dc2626; }

        /* ── Filter Tabs ── */
        .an-filter-tabs {
            display: flex;
            gap: 6px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }
        .an-filter-btn {
            padding: 7px 16px;
            border-radius: 8px;
            font-size: .82rem;
            font-weight: 500;
            border: 1.5px solid #e2e8f0;
            background: #fff;
            color: #64748b;
            cursor: pointer;
            transition: all .18s;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .an-filter-btn.active, .an-filter-btn:hover {
            background: #6366f1;
            border-color: #6366f1;
            color: #fff;
        }

        /* ── Notification Cards ── */
        .an-list { display: flex; flex-direction: column; gap: 10px; }

        .an-card {
            background: #fff;
            border-radius: 14px;
            border: 1.5px solid #e8edf4;
            padding: 16px 20px;
            display: flex;
            align-items: flex-start;
            gap: 14px;
            cursor: pointer;
            transition: all .2s;
            text-decoration: none;
            color: inherit;
            position: relative;
        }
        .an-card:hover { border-color: #6366f1; box-shadow: 0 4px 20px rgba(99,102,241,.1); transform: translateY(-1px); }
        .an-card.unread { border-left: 4px solid #6366f1; background: #fafbff; }

        .an-card-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            flex-shrink: 0;
        }
        .an-card-body { flex: 1; min-width: 0; }
        .an-card-title {
            font-size: .9rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 3px;
        }
        .an-card-msg {
            font-size: .82rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 6px;
        }
        .an-card-footer { display: flex; align-items: center; gap: 10px; }
        .an-card-time { font-size: .72rem; color: #94a3b8; }
        .an-card-type-badge {
            font-size: .7rem;
            font-weight: 600;
            padding: 2px 8px;
            border-radius: 999px;
        }
        .an-unread-dot {
            width: 9px;
            height: 9px;
            background: #6366f1;
            border-radius: 50%;
            flex-shrink: 0;
            margin-top: 6px;
        }

        /* ── Empty State ── */
        .an-empty {
            text-align: center;
            padding: 64px 20px;
            color: #94a3b8;
        }
        .an-empty i { font-size: 3rem; margin-bottom: 16px; display: block; color: #cbd5e1; }
        .an-empty h3 { font-size: 1.1rem; color: #64748b; margin-bottom: 6px; }
        .an-empty p { font-size: .85rem; }

        /* ── Pagination ── */
        .an-pagination { margin-top: 28px; display: flex; justify-content: center; }

        @media (max-width: 600px) {
            .an-card { flex-direction: column; }
            .an-card-icon { width: 38px; height: 38px; font-size: .95rem; }
        }
    </style>
</head>
<body>

    {{-- ── Top Bar ── --}}
    <header class="an-topbar">
        <div class="an-topbar-left">
            <a href="{{ route('admin') }}" class="an-back-btn">
                <i class="fa-solid fa-arrow-left"></i>
                Back to Dashboard
            </a>
            <a href="{{ route('admin') }}" class="an-logo">
                <img src="/logo.png" alt="EngHub">
                <span class="an-logo-tag">ADMIN</span>
            </a>
        </div>
        <div class="an-topbar-right">
            <button class="an-mark-all" id="markAllBtn">
                <i class="fa-solid fa-check-double"></i>
                Mark All as Read
            </button>
        </div>
    </header>

    <main class="an-page">
        {{-- ── Page Header ── --}}
        <div class="an-header">
            <div class="an-title-block">
                <h1><i class="fa-solid fa-bell" style="color:#6366f1;margin-right:8px;font-size:1.3rem;"></i>Notifications</h1>
                <p>All admin notifications since account creation</p>
            </div>
            <div class="an-counts">
                <span class="an-count-chip all">
                    <i class="fa-solid fa-layer-group"></i>
                    {{ $notifications->total() }} total
                </span>
                @php $unreadCount = Auth::user()->unreadNotifications()->count(); @endphp
                @if($unreadCount > 0)
                    <span class="an-count-chip unread">
                        <i class="fa-solid fa-circle" style="font-size:.5rem;"></i>
                        {{ $unreadCount }} unread
                    </span>
                @endif
            </div>
        </div>

        {{-- ── Filter Tabs ── --}}
        <div class="an-filter-tabs">
            <button class="an-filter-btn active" data-filter="all">
                <i class="fa-solid fa-border-all"></i> All
            </button>
            <button class="an-filter-btn" data-filter="material_uploaded">
                <i class="fa-solid fa-cloud-arrow-up"></i> Uploads
            </button>
            <button class="an-filter-btn" data-filter="comment_reported">
                <i class="fa-solid fa-flag"></i> Reported Comments
            </button>
            <button class="an-filter-btn" data-filter="workshop_created">
                <i class="fa-solid fa-calendar-plus"></i> Workshops
            </button>
        </div>

        {{-- ── Notifications List ── --}}
        @php
            $typeConfig = [
                'material_uploaded' => [
                    'color'      => '#3b82f6',
                    'bg'         => 'rgba(59,130,246,0.12)',
                    'icon'       => 'fa-cloud-arrow-up',
                    'label'      => 'Material',
                    'label_bg'   => '#dbeafe',
                    'label_color'=> '#1d4ed8',
                ],
                'comment_reported' => [
                    'color'      => '#ef4444',
                    'bg'         => 'rgba(239,68,68,0.12)',
                    'icon'       => 'fa-flag',
                    'label'      => 'Report',
                    'label_bg'   => '#fee2e2',
                    'label_color'=> '#b91c1c',
                ],
                'workshop_created' => [
                    'color'      => '#f59e0b',
                    'bg'         => 'rgba(245,158,11,0.12)',
                    'icon'       => 'fa-calendar-plus',
                    'label'      => 'Workshop',
                    'label_bg'   => '#fef3c7',
                    'label_color'=> '#b45309',
                ],
            ];
            $defaultConfig = [
                'color'       => '#6366f1',
                'bg'          => 'rgba(99,102,241,0.12)',
                'icon'        => 'fa-bell',
                'label'       => 'General',
                'label_bg'    => '#e0e7ff',
                'label_color' => '#4338ca',
            ];
        @endphp

        <div class="an-list" id="notifList">
            @if($notifications->count() === 0)
                <div class="an-empty">
                    <i class="fa-solid fa-bell-slash"></i>
                    <h3>No notifications</h3>
                    <p>Notifications will appear here when materials are uploaded, comments are reported, or workshops are created</p>
                </div>
            @else
                @foreach($notifications as $notification)
                    @php
                        $data   = $notification->data ?? [];
                        $type   = $data['type']    ?? 'general';
                        $cfg    = $typeConfig[$type] ?? $defaultConfig;
                        $unread = is_null($notification->read_at);
                        $actionUrl = route('notifications.read', $notification->id);
                    @endphp
                    <a href="{{ $actionUrl }}"
                       class="an-card {{ $unread ? 'unread' : '' }}"
                       data-type="{{ $type }}">
                        <div class="an-card-icon" style="background:{{ $cfg['bg'] }};color:{{ $cfg['color'] }};">
                            <i class="fa-solid {{ $cfg['icon'] }}"></i>
                        </div>
                        <div class="an-card-body">
                            <div class="an-card-title">{{ $data['title'] ?? 'Notification' }}</div>
                            <div class="an-card-msg">{{ $data['message'] ?? '' }}</div>
                            <div class="an-card-footer">
                                <span class="an-card-time">
                                    <i class="fa-regular fa-clock" style="margin-right:4px;"></i>
                                    {{ $notification->created_at->diffForHumans() }}
                                </span>
                                <span class="an-card-type-badge"
                                      style="background:{{ $cfg['label_bg'] }};color:{{ $cfg['label_color'] }};">
                                    {{ $cfg['label'] }}
                                </span>
                                @if($unread)
                                    <span style="font-size:.72rem;color:#6366f1;font-weight:600;">● Unread</span>
                                @endif
                            </div>
                        </div>
                        @if($unread)
                            <div class="an-unread-dot"></div>
                        @endif
                    </a>
                @endforeach
            @endif
        </div>

        {{-- ── Pagination ── --}}
        @if($notifications->hasPages())
            <div class="an-pagination">
                {{ $notifications->links() }}
            </div>
        @endif
    </main>

    <script>
        const CSRF = document.querySelector('meta[name="csrf-token"]').content;

        // ── Filter tabs ──
        document.querySelectorAll('.an-filter-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.querySelectorAll('.an-filter-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filter = this.dataset.filter;
                document.querySelectorAll('#notifList .an-card').forEach(card => {
                    if (filter === 'all' || card.dataset.type === filter) {
                        card.style.display = '';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // ── Mark all as read ──
        document.getElementById('markAllBtn').addEventListener('click', async function () {
            const res = await fetch('{{ route("notifications.read-all") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            });
            if ((await res.json()).success) {
                document.querySelectorAll('.an-card.unread').forEach(card => {
                    card.classList.remove('unread');
                    const dot = card.querySelector('.an-unread-dot');
                    if (dot) dot.remove();
                    const unreadText = card.querySelector('span[style*="color:#6366f1"]');
                    if (unreadText && unreadText.textContent.includes('Unread')) unreadText.remove();
                });
                document.querySelectorAll('.an-count-chip.unread').forEach(el => el.remove());
                this.innerHTML = '<i class="fa-solid fa-check"></i> Marked as Read';
                this.style.opacity = '0.6';
            }
        });
    </script>
</body>
</html>
