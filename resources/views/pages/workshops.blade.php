<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- style -->
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/workshops.css') }}" />

    <title>{{ __('messages.ws_title') }} | EngHub</title>
</head>

<body>



    <div class="dashboard-layout">
        <!-- Sidebar -->
        @include('components.sidbar')

        <!-- Main Content Area -->
        <main class="main-content">
            <!-- Top Navbar -->
            @include('components.topNav')

            <div class="content-body">
                <!-- Page Header -->
                <section class="page-header animate-in">
                    <div class="header-content">
                        <h1>{{ __('messages.ws_title') }}</h1>
                        <p>{{ __('messages.ws_subtitle') }}</p>
                    </div>
                    <a href="{{ route('create-workshop') }}" class="btn btn-primary"><i
                            class="fa-solid fa-calendar-plus"></i>
                        {{ __('messages.ws_create') }}</a>
                </section>

                <!-- Search & Filters -->
                <section class="filter-section animate-in">
                    <div class="filters-container">
                        <select class="filter-select">
                            <option value="">{{ __('messages.ws_all_cats') }}</option>
                            <option value="programming">{{ __('messages.ws_cat_prog') }}</option>
                            <option value="soft-skills">{{ __('messages.ws_cat_soft') }}</option>
                            <option value="design">{{ __('messages.ws_cat_design') }}</option>
                            <option value="engineering">{{ __('messages.ws_cat_eng') }}</option>
                        </select>
                        <select class="filter-select">
                            <option value="">{{ __('messages.ws_all_types') }}</option>
                            <option value="online">{{ __('messages.ws_type_online') }}</option>
                            <option value="offline">{{ __('messages.ws_type_offline') }}</option>
                        </select>
                        <select class="filter-select">
                            <option value="">{{ __('messages.ws_any_date') }}</option>
                            <option value="today">{{ __('messages.ws_date_today') }}</option>
                            <option value="this-week">{{ __('messages.ws_date_week') }}</option>
                            <option value="this-month">{{ __('messages.ws_date_month') }}</option>
                        </select>
                    </div>
                </section>

                <!-- Featured Workshop -->
                @php
                    $featuredWorkshop = $workshops->first();
                @endphp
                @if ($featuredWorkshop)
                    <section class="featured-workshop animate-in">
                        <div class="featured-card" style="cursor: pointer;" onclick="window.location.href='{{ route('workshop-details', ['id' => $featuredWorkshop->id]) }}'">
                            <div class="featured-img">
                                <img src="{{ $featuredWorkshop->banner ? asset('storage/' . $featuredWorkshop->banner) : 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800' }}"
                                    alt="Featured Workshop">
                                <span class="featured-tag">{{ __('messages.ws_latest') }}</span>
                            </div>
                            <div class="featured-content">
                                <span class="cat-badge">{{ __('messages.ws_badge') }}</span>
                                <h2>{{ $featuredWorkshop->title }}</h2>
                                <p>{{ Str::limit($featuredWorkshop->description, 150) }}</p>
                                <div class="workshop-meta">
                                    <span><i class="fa-solid fa-calendar"></i>
                                        {{ \Carbon\Carbon::parse($featuredWorkshop->date)->format('M d, Y') }}</span>
                                    <span><i class="fa-solid fa-clock"></i>
                                        {{ \Carbon\Carbon::parse($featuredWorkshop->time)->format('h:i A') }}</span>
                                    <span><i class="fa-solid fa-location-dot"></i>
                                        {{ $featuredWorkshop->location ?? __('messages.ws_type_online') }}</span>
                                </div>
                                <div class="featured-footer">
                                    <span class="seats-left"><i class="fa-solid fa-users"></i>
                                        {{ max(0, $featuredWorkshop->capacity - $featuredWorkshop->registered) }}
                                        {{ __('messages.ws_seats_left') }}</span>
                                    <a href="{{ route('workshop-details', ['id' => $featuredWorkshop->id]) }}"
                                        class="btn btn-outline sm" onclick="event.stopPropagation()">{{ __('messages.ws_details_reg') }}</a>
                                </div>
                            </div>
                        </div>
                    </section>
                @endif

                <!-- Workshops Grid -->
                <section class="workshops-section animate-in">
                    <div class="section-header">
                        <h3>{{ __('messages.ws_upcoming') }}</h3>
                    </div>

                    <div class="workshops-grid">
                        @forelse($workshops as $workshop)
                            <!-- Workshop Card -->
                            <div class="workshop-main-card" style="cursor: pointer;" onclick="window.location.href='{{ route('workshop-details', $workshop->id) }}'">
                                <div class="card-img">
                                    <img src="{{ $workshop->banner ? asset('storage/' . $workshop->banner) : 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&q=80&w=400' }}"
                                        alt="Workshop">
                                    <div class="date-badge">
                                        <span
                                            class="day">{{ \Carbon\Carbon::parse($workshop->date)->format('d') }}</span>
                                        <span
                                            class="month">{{ strtoupper(\Carbon\Carbon::parse($workshop->date)->format('M')) }}</span>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <span class="cat-label">{{ __('messages.ws_badge') }}</span>
                                    <h4>{{ $workshop->title }}</h4>
                                    <p class="instructor">{{ __('messages.ws_location') }}: {{ $workshop->location }}
                                    </p>
                                    <div class="card-meta">
                                        <span><i class="fa-solid fa-calendar"></i> {{ $workshop->date }}</span>
                                    </div>
                                    <div class="card-footer">
                                        <span class="status"><i class="fa-solid fa-users"></i>
                                            {{ $workshop->registered }} {{ __('messages.ws_registered') }}</span>
                                        <a href="{{ route('workshop-details', $workshop->id) }}"
                                            class="btn btn-outline sm" onclick="event.stopPropagation()">{{ __('messages.ws_register') }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                                <i class="fa-solid fa-calendar-xmark"
                                    style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                                <h3>{{ __('messages.ws_no_upcoming') }}</h3>
                                <p>{{ __('messages.ws_check_later') }}</p>
                            </div>
                        @endforelse
                    </div>

                    {{ $workshops->links('vendor.pagination.custom') }}
                </section>
            </div>

            <!-- Footer -->
            @include('components.footer')
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
