<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="../images/favicon.ico" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- style -->
    <link rel="stylesheet" href="../style/global.css" />
    <link rel="stylesheet" href="../style/dashboard.css" />
    <link rel="stylesheet" href="../style/workshop-details.css" />

    <title>{{ $workshop->title }} | EngHub</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>



    <div class="dashboard-layout">
        <!-- Sidebar -->
        @if (!request()->has('admin'))
            @include('components.sidbar')
        @endif

        <!-- Main Content Area -->
        <main class="main-content" @if (request()->has('admin')) style="margin-left: 0; width: 100%;" @endif>
            <!-- Top Navbar -->
            @if (!request()->has('admin'))
                @include('components.topNav')
            @endif

            <div class="content-body" @if (request()->has('admin')) style="padding: 2rem 5%; max-width: 1400px; margin: 0 auto;" @endif>
                <!-- Workshop Hero Section -->
                <section class="workshop-hero animate-in">
                    <div class="workshop-banner">
                        <img src="{{ $workshop->banner ? asset('storage/' . $workshop->banner) : 'https://images.unsplash.com/photo-1633356122544-f134324a6cee?auto=format&fit=crop&q=80&w=1200' }}"
                            alt="Workshop Banner">
                        <div class="banner-overlay">
                            <span class="status-badge upcoming">{{ ucfirst($workshop->status) }}</span>
                        </div>
                    </div>

                    <div class="workshop-header-info">
                        <div class="title-area">
                            <span class="category-tag">{{ $workshop->category ? ucfirst($workshop->category) : 'Workshop' }}</span>
                            <h1>{{ $workshop->title }}</h1>
                            <div class="header-meta">
                                <span><i class="fa-solid fa-location-dot"></i> {{ $workshop->location }}</span>
                                <span><i class="fa-solid fa-users"></i> {{ $workshop->registered }} Registered</span>
                            </div>
                        </div>
                        <div class="action-area">
                            @if(auth()->check() && auth()->id() == $workshop->user_id)
                                <button class="btn btn-outline btn-lg register-btn" disabled style="opacity:0.8;cursor:not-allowed;background:rgba(255,255,255,0.1);border-color:white;color:white;">
                                    <i class="fa-solid fa-crown"></i> Your Workshop
                                </button>
                            @elseif($workshop->isFull())
                                <button class="btn btn-primary btn-lg register-btn" disabled style="opacity:0.6;cursor:not-allowed;">
                                    <i class="fa-solid fa-lock"></i> {{ __('messages.wsd_full') }}
                                </button>
                                <span style="font-size:0.85rem;color:#ef4444;margin-top:6px;display:block;"><i class="fa-solid fa-circle-exclamation"></i> {{ __('messages.wsd_no_seats') }}</span>
                            @elseif($isRegistered)
                                <button class="btn btn-primary btn-lg register-btn" disabled style="background:#059669;opacity:0.9;">
                                    <i class="fa-solid fa-check"></i> {{ __('messages.wsd_already_reg') }} ✅
                                </button>
                            @else
                                <button class="btn btn-primary btn-lg register-btn" id="registerBtn"
                                    onclick="registerWorkshop({{ $workshop->id }})">
                                    <i class="fa-solid fa-user-plus"></i> {{ __('messages.wsd_reg_now') }}
                                </button>
                                <span style="font-size:0.85rem;color:#64748b;margin-top:6px;display:block;">
                                    <i class="fa-solid fa-users"></i>
                                    {{ $workshop->capacity - $workshop->registered }} {{ __('messages.wsd_seats_left_out_of') }} {{ $workshop->capacity }}
                                </span>
                            @endif
                        </div>
                    </div>
                </section>

                <!-- Main Details Layout -->
                <div class="details-grid">
                    <!-- Left Side: Content -->
                    <div class="details-main-content">
                        <!-- Info Cards Row -->
                        <section class="info-cards-row animate-in">
                            <div class="info-mini-card">
                                <i class="fa-solid fa-calendar-day"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.wsd_date') }}</span>
                                    <span class="val">{{ $workshop->date }}</span>
                                </div>
                            </div>
                            <div class="info-mini-card">
                                <i class="fa-solid fa-location-dot"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.ws_location') }}</span>
                                    <span class="val">{{ $workshop->location }}</span>
                                </div>
                            </div>
                            <div class="info-mini-card">
                                <i class="fa-solid fa-users"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.ws_registered') }}</span>
                                    <span class="val">{{ $workshop->registered }}</span>
                                </div>
                            </div>
                            @if($workshop->time)
                            <div class="info-mini-card">
                                <i class="fa-solid fa-clock"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.wsd_time') }}</span>
                                    <span class="val">{{ \Carbon\Carbon::parse($workshop->time)->format('h:i A') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($workshop->duration)
                            <div class="info-mini-card">
                                <i class="fa-solid fa-hourglass-half"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.wsd_duration') }}</span>
                                    <span class="val">{{ $workshop->duration }} {{ __('messages.wsd_hours') }}</span>
                                </div>
                            </div>
                            @endif
                            @if($workshop->type)
                            <div class="info-mini-card">
                                <i class="fa-solid fa-globe"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.wsd_type') }}</span>
                                    <span class="val">{{ ucfirst($workshop->type) }}</span>
                                </div>
                            </div>
                            @endif
                            @if($workshop->instructor_name)
                            <div class="info-mini-card">
                                <i class="fa-solid fa-user-tie"></i>
                                <div class="txt">
                                    <span class="label">{{ __('messages.wsd_instructor') }}</span>
                                    <span class="val">{{ $workshop->instructor_name }}</span>
                                </div>
                            </div>
                            @endif
                        </section>

                        <!-- Description -->
                        <section class="details-block animate-in">
                            <h3>{{ __('messages.wsd_desc') }}</h3>
                            <p>{{ $workshop->description ?: __('messages.wsd_no_desc') }}</p>
                        </section>

                        <!-- Topics Covered -->
                        <section class="details-block animate-in">
                            <h3>{{ __('messages.wsd_learn') }}</h3>
                            <div class="topics-grid">
                                <div class="topic-item"><i class="fa-solid fa-circle-check"></i> React Basics & JSX
                                </div>
                                <div class="topic-item"><i class="fa-solid fa-circle-check"></i> Components & Props
                                </div>
                                <div class="topic-item"><i class="fa-solid fa-circle-check"></i> State & UseState Hook
                                </div>
                                <div class="topic-item"><i class="fa-solid fa-circle-check"></i> Handling Events</div>
                                <div class="topic-item"><i class="fa-solid fa-circle-check"></i> Project Structure
                                </div>
                                <div class="topic-item"><i class="fa-solid fa-circle-check"></i> Modern UI Patterns
                                </div>
                            </div>
                        </section>

                        <!-- Resources -->
                        @if($workshop->pdf_slides || $workshop->useful_links)
                        <section class="details-block animate-in">
                            <h3><i class="fa-solid fa-folder-open" style="margin-right:8px;color:var(--primary)"></i>{{ __('messages.wsd_resources') }}</h3>
                            <div style="display:flex;flex-direction:column;gap:12px;margin-top:12px;">
                                @if($workshop->pdf_slides)
                                <a href="{{ asset('storage/' . $workshop->pdf_slides) }}" target="_blank"
                                   style="display:flex;align-items:center;gap:12px;padding:14px 18px;background:rgba(6,111,108,0.07);border-radius:10px;text-decoration:none;color:var(--primary);font-weight:600;transition:all 0.2s;border:1px solid rgba(6,111,108,0.15);"
                                   onmouseover="this.style.background='rgba(6,111,108,0.14)'" onmouseout="this.style.background='rgba(6,111,108,0.07)'">
                                    <i class="fa-solid fa-file-pdf" style="font-size:1.4rem;color:#e53e3e;"></i>
                                    <div>
                                        <div style="font-size:0.95rem;">{{ __('messages.wsd_pdf_slides') }}</div>
                                        <div style="font-size:0.75rem;font-weight:400;color:#64748b;">{{ __('messages.wsd_click_download') }}</div>
                                    </div>
                                    <i class="fa-solid fa-download" style="margin-left:auto;"></i>
                                </a>
                                @endif

                                @if($workshop->useful_links)
                                <div style="padding:14px 18px;background:rgba(6,111,108,0.07);border-radius:10px;border:1px solid rgba(6,111,108,0.15);">
                                    <div style="display:flex;align-items:center;gap:10px;font-weight:600;color:var(--primary);margin-bottom:10px;">
                                        <i class="fa-solid fa-link"></i> {{ __('messages.wsd_links') }}
                                    </div>
                                    @foreach(explode(',', $workshop->useful_links) as $link)
                                        @php $link = trim($link); @endphp
                                        @if($link)
                                        <a href="{{ Str::startsWith($link, 'http') ? $link : 'https://' . $link }}" target="_blank"
                                           style="display:block;padding:6px 0;color:#3b82f6;text-decoration:none;font-size:0.9rem;word-break:break-all;"
                                           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                                            <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.75rem;margin-right:5px;"></i>{{ $link }}
                                        </a>
                                        @endif
                                    @endforeach
                                </div>
                                @endif
                            </div>
                        </section>
                        @endif
                    </div>

                    <!-- Right Side: Sidebar Info -->
                    <div class="details-sidebar-content">

                        <!-- Capacity Progress Card -->
                        <div class="instructor-card-detail animate-in" style="margin-bottom:1.5rem;">
                            <h3><i class="fa-solid fa-chart-simple" style="margin-right:6px;"></i>{{ __('messages.wsd_reg_status') }}</h3>
                            <div style="margin-top:12px;">
                                <div style="display:flex;justify-content:space-between;font-size:0.9rem;font-weight:600;margin-bottom:8px;">
                                    <span>{{ $workshop->registered }} {{ __('messages.ws_registered') }}</span>
                                    <span style="color:#64748b;">{{ $workshop->capacity }} {{ __('messages.wsd_capacity') }}</span>
                                </div>
                                <div style="background:#f1f5f9;border-radius:999px;height:10px;overflow:hidden;">
                                    <div style="background:{{ $workshop->isFull() ? '#ef4444' : 'var(--primary)' }};height:100%;border-radius:999px;width:{{ $workshop->capacity > 0 ? min(100, round($workshop->registered / $workshop->capacity * 100)) : 0 }}%;transition:width 0.4s;"></div>
                                </div>
                                <p style="margin-top:8px;font-size:0.8rem;color:{{ $workshop->isFull() ? '#ef4444' : '#64748b' }};">
                                    @if($workshop->isFull()) <i class="fa-solid fa-lock"></i> {{ __('messages.wsd_is_full') }}
                                    @else <i class="fa-solid fa-circle-check" style="color:var(--primary);"></i> {{ $workshop->capacity - $workshop->registered }} {{ __('messages.wsd_seats_remaining') }} @endif
                                </p>
                            </div>
                        </div>

                        <!-- Registered Students -->
                        <div class="instructor-card-detail animate-in">
                            <h3><i class="fa-solid fa-users" style="margin-right:6px;"></i>{{ __('messages.wsd_reg_students') }}
                                <span style="background:var(--primary);color:white;font-size:0.75rem;padding:2px 8px;border-radius:999px;margin-left:8px;">{{ $workshop->registered }}</span>
                            </h3>
                            @if($workshop->registeredUsers->count() > 0)
                            <div style="margin-top:12px;display:flex;flex-direction:column;gap:10px;max-height:300px;overflow-y:auto;">
                                @foreach($workshop->registeredUsers as $student)
                                <div style="display:flex;align-items:center;gap:10px;padding:8px;border-radius:8px;background:#f8fafc;position:relative;">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($student->first_name . ' ' . $student->last_name) }}&background=066f6c&color=fff&size=36"
                                         style="width:36px;height:36px;border-radius:50%;" alt="{{ $student->first_name }}">
                                    <div style="flex-grow:1;">
                                        <div style="font-size:0.9rem;font-weight:600;color:#1e293b;">{{ $student->first_name }} {{ $student->last_name }}</div>
                                        <div style="font-size:0.75rem;color:#64748b;">{{ $student->email }}</div>
                                    </div>
                                    @if(auth()->check() && auth()->id() == $workshop->user_id)
                                    <button onclick="removeAttendee({{ $workshop->id }}, {{ $student->id }})" style="background:none;border:none;color:#ef4444;cursor:pointer;padding:4px;" title="Remove Attendee">
                                        <i class="fa-solid fa-user-minus"></i>
                                    </button>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                            @else
                            <p style="margin-top:12px;color:#94a3b8;font-size:0.9rem;text-align:center;padding:20px 0;">
                                <i class="fa-solid fa-user-slash" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>
                                {{ __('messages.wsd_no_students') }}
                            </p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


            <!-- Footer -->
            @if (!request()->has('admin'))
                @include('components.footer')
            @endif
        </main>
    </div>

    <meta name="workshop-id" content="{{ $workshop->id }}">
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script>
        function registerWorkshop(workshopId) {
            const btn = document.getElementById('registerBtn');
            btn.disabled = true;
            btn.innerHTML = `<i class="fa-solid fa-spinner fa-spin"></i> {{ __('messages.wsd_registering') }}`;

            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            fetch(`/workshops/${workshopId}/register`, {
                method: 'POST',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    btn.innerHTML = `<i class="fa-solid fa-check"></i> {{ __('messages.wsd_already_reg') }} ✅`;
                    btn.style.backgroundColor = '#059669';
                    // Update counter
                    const countEls = document.querySelectorAll('[data-registered]');
                    document.querySelectorAll('.registered-count').forEach(el => el.textContent = data.registered);
                    // Reload to show in list
                    setTimeout(() => location.reload(), 1200);
                } else {
                    btn.disabled = false;
                    btn.innerHTML = `<i class="fa-solid fa-user-plus"></i> {{ __('messages.wsd_reg_now') }}`;
                    alert(data.message || 'Registration failed');
                }
            })
            .catch(() => {
                btn.disabled = false;
                btn.innerHTML = `<i class="fa-solid fa-user-plus"></i> {{ __('messages.wsd_reg_now') }}`;
            });
        }

        function removeAttendee(workshopId, userId) {
            if(!confirm('Are you sure you want to remove this attendee?')) return;
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            fetch(`/workshops/${workshopId}/attendees/${userId}`, {
                method: 'DELETE',
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            })
            .then(r => r.json())
            .then(data => {
                if(data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(()=> alert('Error removing attendee.'));
        }
    </script>
</body>

</html>
