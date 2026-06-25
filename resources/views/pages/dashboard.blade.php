<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Your personal EngHub dashboard — track courses, uploads and upcoming workshops." />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <title>Dashboard | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        <!-- Sidebar Navigation -->
        @include('components.sidbar')

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Nav -->
            @include('components.topNav')

            <!-- Inner Content -->
            <div style="padding: var(--space-2xl); display: flex; flex-direction: column; gap: var(--space-xl);">

                <!-- Welcome Widget -->
                <div
                    style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%); color: white; border-radius: var(--radius-lg); padding: var(--space-2xl); position: relative; overflow: hidden; box-shadow: var(--shadow-lg);">
                    <div style="position: relative; z-index: 2;">
                        <h1 style="color: white; font-size: 2.25rem; margin-bottom: var(--space-xs); font-weight: 800;">
                            {{ __('messages.dash_welcome') }}, {{ $user->first_name }} 👋</h1>
                        <p
                            style="font-size: 1.1rem; opacity: 0.9; max-width: 600px; font-weight: 300; line-height: 1.6;">
                            {{ __('messages.dash_overview') }}
                            @if($user->major)
                                {{ __('messages.dash_for') }} <strong style="font-weight: 700; color: var(--secondary-light);">{{ $user->major }}</strong>.
                            @else
                                {{ __('messages.dash_on_enghub') }}
                            @endif
                        </p>
                        @if($user->academic_year)
                            <span style="display:inline-block; margin-top: var(--space-sm); background: rgba(255,255,255,0.2); border-radius: var(--radius-full); padding: 4px 14px; font-size: 0.85rem; font-weight: 600;">
                                <i class="fa-solid fa-graduation-cap" style="margin-right:5px;"></i>{{ __('messages.dash_year') }} {{ $user->academic_year }}
                            </span>
                        @endif
                    </div>
                    <!-- decorative shape overlay -->
                    <div
                        style="position: absolute; right: -50px; bottom: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.05); border-radius: 50%;">
                    </div>
                    <div
                        style="position: absolute; right: 80px; top: -30px; width: 150px; height: 150px; background: rgba(255,255,255,0.04); border-radius: 50%;">
                    </div>
                </div>

                <!-- Stats Widgets Row -->
                <div
                    style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: var(--space-lg);">

                    <div class="card"
                        style="padding: var(--space-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-xs);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                            <span
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">{{ __('messages.dash_avail_courses') }}</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">
                            {{ $coursesCount }} <span style="font-size:1rem; font-weight:500;">{{ __('messages.dash_courses') }}</span>
                        </h3>
                    </div>

                    <div class="card"
                        style="padding: var(--space-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-xs);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                            <span
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">{{ __('messages.dash_my_uploads') }}</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: rgba(241, 130, 45, 0.1); display: flex; align-items: center; justify-content: center; color: var(--secondary);">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">
                            {{ $uploadedCount }} <span style="font-size:1rem; font-weight:500;">{{ __('messages.dash_files') }}</span>
                        </h3>
                    </div>

                    <div class="card"
                        style="padding: var(--space-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-xs);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                            <span
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">{{ __('messages.dash_workshops_joined') }}</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">
                            {{ $workshopsCount }} <span style="font-size:1rem; font-weight:500;">{{ __('messages.dash_enrolled') }}</span>
                        </h3>
                    </div>

                    <div class="card"
                        style="padding: var(--space-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-xs);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                            <span
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">{{ __('messages.dash_my_favorites') }}</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: rgba(239,68,68,0.1); display: flex; align-items: center; justify-content: center; color: #ef4444;">
                                <i class="fa-solid fa-heart"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">
                            {{ $user->favorites()->count() }} <span style="font-size:1rem; font-weight:500;">{{ __('messages.dash_saved') }}</span>
                        </h3>
                    </div>

                </div>

                <!-- Two Column Details Section -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--space-xl); align-items: start;">

                    <!-- Left Column -->
                    <div style="display: flex; flex-direction: column; gap: var(--space-xl);">

                        <!-- Courses from DB -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <div style="display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm); margin-bottom: var(--space-md);">
                                <h2 style="font-size: 1.35rem; color: var(--primary-dark); margin: 0; display: flex; align-items: center;">
                                    <i class="fa-solid fa-graduation-cap" style="color: var(--primary); margin-right: var(--space-sm);"></i>
                                    {{ __('messages.dash_year_courses', ['year' => $selectedYear]) }}
                                </h2>
                                <a href="{{ route('courses') }}"
                                    style="font-size: 0.85rem; background: var(--primary-light); color: var(--primary); padding: 4px 10px; border-radius: var(--radius-full); font-weight: 700; text-decoration:none;">{{ __('messages.dash_view_all') }}</a>
                            </div>

                            <!-- Year Tabs -->
                            <div style="display: flex; gap: var(--space-xs); margin-bottom: var(--space-md); overflow-x: auto; padding-bottom: 4px;">
                                @for($i = 1; $i <= $maxYears; $i++)
                                    <a href="{{ route('dashboard', ['year' => $i]) }}" 
                                       class="btn {{ $selectedYear == $i ? 'btn-primary' : 'btn-outline' }}"
                                       style="padding: 4px 12px; font-size: 0.85rem; border-radius: var(--radius-full); text-decoration: none; {{ $selectedYear == $i ? 'box-shadow: none;' : 'background: transparent; color: var(--text-secondary); border-color: var(--border-color);' }}">
                                       {{ __('messages.dash_year') }} {{ $i }}
                                    </a>
                                @endfor
                            </div>

                            @forelse($courses as $course)
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #fafbfc; margin-bottom: var(--space-sm);">
                                    <div style="display: flex; gap: var(--space-md); align-items: center;">
                                        <div
                                            style="width: 48px; height: 40px; border-radius: var(--radius-md); background: rgba(6, 111, 108, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800; font-size:0.75rem; text-align:center; padding:2px;">
                                            {{ $course->code ?? 'N/A' }}</div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1.05rem; color: var(--primary-dark);">
                                                {{ $course->title }}</h4>
                                            <span style="font-size: 0.8rem; color: var(--text-muted);">
                                                {{ $course->materials_count }} {{ Str::plural('file', $course->materials_count) }}
                                                @if($course->semester) &nbsp;•&nbsp; Semester {{ $course->semester }} @endif
                                            </span>
                                        </div>
                                    </div>
                                    <a href="{{ route('course.details', ['id' => $course->id]) }}"
                                        class="btn btn-outline"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: var(--radius-sm);">{{ __('messages.dash_explore') }}</a>
                                </div>
                            @empty
                                <div style="text-align:center; padding: var(--space-xl); color: var(--text-muted);">
                                    <i class="fa-solid fa-book-open" style="font-size:2rem; margin-bottom:0.5rem; opacity:0.4;"></i>
                                    <p style="margin:0;">{{ __('messages.dash_no_courses') }}</p>
                                    <a href="{{ route('courses') }}" style="color:var(--primary); font-size:0.9rem;">{!! __('messages.dash_browse_all') !!}</a>
                                </div>
                            @endforelse
                        </div>

                        <!-- My Recent Uploads -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <h2
                                style="font-size: 1.35rem; color: var(--primary-dark); margin-bottom: var(--space-md); border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm);">
                                <i class="fa-solid fa-clock-rotate-left"
                                    style="color: var(--primary); margin-right: var(--space-sm);"></i>{{ __('messages.dash_recent_uploads') }}
                            </h2>
                            @forelse($recentUploads as $upload)
                                <div
                                    style="display: flex; gap: var(--space-md); align-items: center; padding: var(--space-sm) 0; border-bottom: 1px solid var(--border-light);">
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: var(--secondary); flex-shrink:0;"></div>
                                    <div style="flex:1; min-width:0;">
                                        <p style="margin: 0; font-size: 0.95rem; color: var(--text-secondary); white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                            <strong>{{ $upload->title }}</strong>
                                            @if($upload->course)
                                                <span style="color:var(--text-muted);"> &mdash; {{ $upload->course->title }}</span>
                                            @endif
                                        </p>
                                    </div>
                                    <span style="margin-left: auto; font-size: 0.8rem; color: var(--text-muted); white-space:nowrap; flex-shrink:0;">
                                        {{ $upload->created_at->diffForHumans() }}
                                    </span>
                                </div>
                            @empty
                                <div style="text-align:center; padding: var(--space-lg); color: var(--text-muted);">
                                    <i class="fa-solid fa-cloud-arrow-up" style="font-size:1.8rem; opacity:0.35; display:block; margin-bottom:0.4rem;"></i>
                                    {{ __('messages.dash_no_uploads') }}
                                    <a href="{{ route('upload') }}" style="color:var(--primary); display:block; margin-top:4px; font-size:0.9rem;">{!! __('messages.dash_upload_first') !!}</a>
                                </div>
                            @endforelse
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div style="display: flex; flex-direction: column; gap: var(--space-xl);">

                        <!-- Quick Actions -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <h2 style="font-size: 1.25rem; color: var(--primary-dark); margin-bottom: var(--space-md); border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm);">
                                <i class="fa-solid fa-bolt" style="color: var(--secondary); margin-right: var(--space-sm);"></i>{{ __('messages.dash_quick_actions') }}
                            </h2>
                            <div style="display: flex; flex-direction: column; gap: var(--space-sm);">
                                <a href="{{ route('upload') }}" class="btn btn-primary" style="text-align:center; text-decoration:none;">
                                    <i class="fa-solid fa-cloud-arrow-up" style="margin-right:6px;"></i>{{ __('messages.dash_upload_material') }}
                                </a>
                                <a href="{{ route('courses') }}" class="btn btn-outline" style="text-align:center; text-decoration:none;">
                                    <i class="fa-solid fa-book-open" style="margin-right:6px;"></i>{{ __('messages.dash_browse_courses') }}
                                </a>
                                <a href="{{ route('workshops') }}" class="btn btn-outline" style="text-align:center; text-decoration:none;">
                                    <i class="fa-solid fa-laptop-code" style="margin-right:6px;"></i>{{ __('messages.dash_find_workshops') }}
                                </a>
                                <a href="{{ route('favorites') }}" class="btn btn-outline" style="text-align:center; text-decoration:none;">
                                    <i class="fa-solid fa-heart" style="margin-right:6px;"></i>{{ __('messages.dash_my_favorites') }}
                                </a>
                            </div>
                        </div>

                        <!-- Upcoming Workshops from DB -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <h2
                                style="font-size: 1.25rem; color: var(--primary-dark); margin-bottom: var(--space-md); border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm);">
                                <i class="fa-solid fa-laptop-code"
                                    style="color: var(--primary); margin-right: var(--space-sm);"></i>{{ __('messages.dash_upcoming_ws') }}
                            </h2>
                            @php
                                $wsColors = ['var(--secondary)', '#3b82f6', '#8b5cf6', '#14b8a6'];
                            @endphp
                            <div style="display: flex; flex-direction: column; gap: var(--space-lg);">
                                @forelse($upcomingWorkshops as $i => $ws)
                                    <div style="border-left: 3px solid {{ $wsColors[$i % count($wsColors)] }}; padding-left: var(--space-sm);">
                                        <h4 style="margin: 0; font-size: 0.95rem; color: var(--primary-dark);">{{ $ws->title }}</h4>
                                        <span style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;">
                                            <i class="fa-regular fa-calendar-days" style="margin-right: 4px;"></i>
                                            {{ \Carbon\Carbon::parse($ws->date)->format('M d') }}
                                            @if($ws->time), {{ \Carbon\Carbon::parse($ws->time)->format('H:i') }}@endif
                                        </span>
                                        @if($ws->isFull())
                                            <span style="font-size:0.72rem; color:#ef4444; font-weight:600;">{{ __('messages.dash_full') }}</span>
                                        @else
                                            <a href="{{ route('workshop-details', $ws->id) }}" style="font-size:0.75rem; color:var(--primary); font-weight:600; text-decoration:none;">{!! __('messages.dash_register') !!}</a>
                                        @endif
                                    </div>
                                @empty
                                    <div style="text-align:center; color: var(--text-muted); font-size:0.9rem; padding: var(--space-md) 0;">
                                        <i class="fa-regular fa-calendar-xmark" style="font-size:1.5rem; opacity:0.4; display:block; margin-bottom:6px;"></i>
                                        {{ __('messages.dash_no_ws') }}
                                    </div>
                                @endforelse
                            </div>
                            @if($upcomingWorkshops->count())
                                <a href="{{ route('workshops') }}" style="display:block; text-align:center; margin-top: var(--space-md); font-size:0.85rem; color:var(--primary); font-weight:600; text-decoration:none;">{!! __('messages.dash_view_all_ws') !!}</a>
                            @endif
                        </div>

                    </div>
                </div>

            </div>

            <!-- Footer -->
            @include('components.footer')
        </main>
    </div>
</body>

</html>
