<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="description" content="Browse engineering courses and study materials on EngHub." />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/courses.css') }}" />
    <title>Courses | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidbar')
        <main class="main-content">
            @include('components.topNav')

            <div class="dashboard-inner-content">

                <!-- Page Header -->
                <div class="page-header"
                    style="background: white; border-radius: var(--radius-lg); padding: var(--space-xl); border: 1px solid rgba(0,0,0,0.03); box-shadow: var(--shadow-sm); margin-bottom: var(--space-xl);">
                    <div class="header-content">
                        <h1 style="font-size: 2rem; color: var(--primary-dark); margin-bottom: var(--space-xs);">{{ __('messages.crs_title') }}</h1>
                        <p style="color: var(--text-muted); font-size: 1rem;">
                            {{ __('messages.crs_subtitle') }}
                            <strong style="color:var(--primary);">{{ $courses->count() }}</strong> {{ __('messages.crs_found') }}
                        </p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filter-section"
                    style="background: white; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid rgba(0,0,0,0.03); margin-bottom: var(--space-xl);">
                    <form method="GET" action="{{ route('courses') }}" id="filter-form">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-md);">

                            <!-- Year filter -->
                            <div style="display: flex; gap: var(--space-sm); flex-wrap: wrap; align-items: center;">
                                <div style="display: flex; background: var(--bg-main); padding: 4px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                                    <a href="{{ route('courses', array_filter(['semester' => $semester])) }}"
                                        class="btn {{ !$year ? 'btn-primary' : 'btn-outline' }}"
                                        style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; {{ !$year ? 'box-shadow:none;' : 'background:transparent; color:var(--text-secondary);' }} text-decoration:none;">
                                        {{ __('messages.crs_all_years') }}
                                    </a>
                                    @foreach($allYears as $yr)
                                        <a href="{{ route('courses', array_filter(['year' => $yr, 'semester' => $semester])) }}"
                                            class="btn {{ $year == $yr ? 'btn-primary' : 'btn-outline' }}"
                                            style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; {{ $year == $yr ? 'box-shadow:none;' : 'background:transparent; color:var(--text-secondary);' }} text-decoration:none;">
                                            {{ __('messages.crs_year') }} {{ $yr }}
                                        </a>
                                    @endforeach
                                </div>

                                <!-- Semester filter -->
                                <div style="display: flex; background: var(--bg-main); padding: 4px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                                    <a href="{{ route('courses', array_filter(['year' => $year])) }}"
                                        class="btn {{ !$semester ? 'btn-primary' : 'btn-outline' }}"
                                        style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; {{ !$semester ? 'box-shadow:none;' : 'background:transparent; color:var(--text-secondary);' }} text-decoration:none;">
                                        {{ __('messages.crs_all_semesters') }}
                                    </a>
                                    @foreach($allSemesters as $sem)
                                        <a href="{{ route('courses', array_filter(['year' => $year, 'semester' => $sem])) }}"
                                            class="btn {{ $semester == $sem ? 'btn-primary' : 'btn-outline' }}"
                                            style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; {{ $semester == $sem ? 'box-shadow:none;' : 'background:transparent; color:var(--text-secondary);' }} text-decoration:none;">
                                            {{ is_numeric($sem) ? __('messages.crs_semester').' '.$sem : ucfirst($sem) }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>

                            <!-- Search -->
                            <div style="display:flex; gap: var(--space-sm); align-items:center;">
                                @if($year || $semester)
                                    <a href="{{ route('courses') }}" class="btn btn-outline" style="padding: 0.5rem 1rem; font-size:0.85rem; border-radius: var(--radius-md); text-decoration:none; color:#ef4444; border-color:#ef4444;">
                                        <i class="fa-solid fa-xmark"></i> {{ __('messages.crs_clear_filters') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Course Grid -->
                @php
                    $iconColors = [
                        '#3b82f6','#10b981','#f59e0b','#ef4444','#8b5cf6','#14b8a6','#f97316','#06b6d4'
                    ];
                    $icons = [
                        'fa-bolt','fa-book','fa-flask','fa-compass','fa-microchip','fa-gears',
                        'fa-code','fa-calculator','fa-atom','fa-drafting-compass'
                    ];
                @endphp

                @if($courses->isEmpty())
                    <div style="text-align:center; background:white; border-radius: var(--radius-lg); padding: 4rem 2rem; box-shadow: var(--shadow-sm);">
                        <i class="fa-solid fa-book-open" style="font-size:3rem; color:var(--border-color); display:block; margin-bottom:1rem;"></i>
                        <h3 style="color:var(--text-secondary); margin-bottom:0.5rem;">{{ __('messages.crs_no_found') }}</h3>
                        <p style="color:var(--text-muted);">{{ __('messages.crs_try_changing') }}</p>
                        <a href="{{ route('courses') }}" class="btn btn-primary" style="margin-top:1rem; text-decoration:none;">{{ __('messages.crs_view_all') }}</a>
                    </div>
                @else
                    <div class="course-grid">
                        @foreach($courses as $i => $course)
                            @php
                                $color = $iconColors[$i % count($iconColors)];
                                $icon  = $icons[$i % count($icons)];
                                $bg    = $color . '1a';
                            @endphp
                            <a href="{{ route('course.details', ['id' => $course->id]) }}" class="course-main-card"
                                style="text-decoration:none; color:inherit; display:block;">
                                <div class="course-card-body">
                                    <div class="course-icon" style="color: {{ $color }}; background-color: {{ $bg }};">
                                        <i class="fa-solid {{ $icon }}"></i>
                                    </div>
                                    <div class="course-info">
                                        <span class="course-code" style="color: {{ $color }};">{{ $course->code ?? 'N/A' }}</span>
                                        <h4>{{ $course->title }}</h4>
                                        <p>{{ Str::limit($course->description ?? __('messages.crs_no_desc'), 90) }}</p>

                                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: var(--space-md);">
                                            <div style="display: flex; align-items: center; gap: 6px; font-size: 0.82rem; color: var(--text-muted);">
                                                <i class="fa-solid fa-user-tie" style="color:var(--primary);"></i>
                                                <span>{{ $course->instructor ?? __('messages.crs_unknown_inst') }}</span>
                                            </div>
                                            <div style="display: flex; align-items: center; gap: 4px; font-size: 0.82rem;">
                                                @if($course->year)
                                                    <span style="background: var(--primary-light); color: var(--primary); padding: 2px 8px; border-radius: 10px; font-weight:600;">
                                                        {{ __('messages.crs_y') }}{{ $course->year }}
                                                        @if($course->semester) - {{ __('messages.crs_s') }}{{ $course->semester }} @endif
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="course-card-footer"
                                    style="display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: center; gap: 12px;">
                                        <span style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">
                                            <i class="fa-solid fa-folder-open" style="color:var(--primary); margin-right:4px;"></i>
                                            {{ $course->materials_count }} {{ __('messages.crs_res') }}
                                        </span>
                                        @php
                                            $cardContributors = $course->materials->pluck('user')->filter()->unique('id')->take(3);
                                            $totalContributors = $course->materials->pluck('user')->filter()->unique('id')->count();
                                        @endphp
                                        @if($totalContributors > 0)
                                            <div style="display: flex; margin-left: 4px;">
                                                @foreach($cardContributors as $contributor)
                                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: var(--primary-light); color: var(--primary); display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: bold; border: 2px solid white; margin-left: -8px; z-index: {{ 10 - $loop->index }}; position: relative;" title="{{ $contributor->first_name }} {{ $contributor->last_name }}">
                                                        {{ strtoupper(substr($contributor->first_name, 0, 1) . substr($contributor->last_name, 0, 1)) }}
                                                    </div>
                                                @endforeach
                                                @if($totalContributors > 3)
                                                    <div style="width: 24px; height: 24px; border-radius: 50%; background: #e2e8f0; color: #64748b; display: flex; align-items: center; justify-content: center; font-size: 0.6rem; font-weight: bold; border: 2px solid white; margin-left: -8px; z-index: 1; position: relative;">
                                                        +{{ $totalContributors - 3 }}
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <span style="font-size:0.8rem; color:var(--text-muted); font-weight: 600;">
                                        {{ __('messages.dash_explore') }} <i class="fa-solid fa-arrow-{{ App::getLocale() == 'ar' ? 'left' : 'right' }}" style="font-size:0.7rem; margin-left: 2px;"></i>
                                    </span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    {{ $courses->links('vendor.pagination.custom') }}
                @endif

            </div>

            @include('components.footer')
        </main>
    </div>
</body>

</html>
