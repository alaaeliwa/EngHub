<!doctype html>
<html lang="en">

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
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/workshops.css') }}" />

    <title>Workshops & Events | EngHub</title>
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
                        <h1>Workshops & Events</h1>
                        <p>Join educational workshops, programming sessions, and student activities.</p>
                    </div>
                    <a href="{{ route('create-workshop') }}" class="btn btn-primary"><i
                            class="fa-solid fa-calendar-plus"></i>
                        Create Workshop</a>
                </section>

                <!-- Search & Filters -->
                <section class="filter-section animate-in">
                    <div class="filters-container">
                        <select class="filter-select">
                            <option value="">All Categories</option>
                            <option value="programming">Programming</option>
                            <option value="soft-skills">Soft Skills</option>
                            <option value="design">Design</option>
                            <option value="engineering">Engineering Tools</option>
                        </select>
                        <select class="filter-select">
                            <option value="">All Types</option>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                        <select class="filter-select">
                            <option value="">Any Date</option>
                            <option value="today">Today</option>
                            <option value="this-week">This Week</option>
                            <option value="this-month">This Month</option>
                        </select>
                    </div>
                </section>

                <!-- Featured Workshop -->
                <section class="featured-workshop animate-in">
                    <div class="featured-card">
                        <div class="featured-img">
                            <img src="https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=800"
                                alt="Featured Workshop">
                            <span class="featured-tag">Featured</span>
                        </div>
                        <div class="featured-content">
                            <span class="cat-badge">Programming</span>
                            <h2>Mastering React & Next.js</h2>
                            <p>Learn how to build production-ready applications with modern web technologies. This
                                session covers performance, SEO, and advanced state management.</p>
                            <div class="workshop-meta">
                                <span><i class="fa-solid fa-calendar"></i> May 25, 2026</span>
                                <span><i class="fa-solid fa-clock"></i> 07:00 PM</span>
                                <span><i class="fa-solid fa-location-dot"></i> Online (Zoom)</span>
                            </div>
                            <div class="featured-footer">
                                <span class="seats-left"><i class="fa-solid fa-users"></i> 15 Seats Left</span>
                                <a href="{{ route('workshop-details') }}" class="btn btn-outline sm">Register</a>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- Workshops Grid -->
                <section class="workshops-section animate-in">
                    <div class="section-header">
                        <h3>Upcoming Workshops</h3>
                    </div>

                    <div class="workshops-grid">
                        @forelse($workshops as $workshop)
                        <!-- Workshop Card -->
                        <div class="workshop-main-card">
                            <div class="card-img">
                                <img src="{{ $workshop->banner ? asset('storage/' . $workshop->banner) : 'https://images.unsplash.com/photo-1586281380349-632531db7ed4?auto=format&fit=crop&q=80&w=400' }}"
                                    alt="Workshop">
                                <div class="date-badge">
                                    <span class="day">{{ \Carbon\Carbon::parse($workshop->date)->format('d') }}</span>
                                    <span class="month">{{ strtoupper(\Carbon\Carbon::parse($workshop->date)->format('M')) }}</span>
                                </div>
                            </div>
                            <div class="card-content">
                                <span class="cat-label">Workshop</span>
                                <h4>{{ $workshop->title }}</h4>
                                <p class="instructor">Location: {{ $workshop->location }}</p>
                                <div class="card-meta">
                                    <span><i class="fa-solid fa-calendar"></i> {{ $workshop->date }}</span>
                                </div>
                                <div class="card-footer">
                                    <span class="status"><i class="fa-solid fa-users"></i> {{ $workshop->registered }} Registered</span>
                                    <a href="{{ route('workshop-details', $workshop->id) }}" class="btn btn-outline sm">Register</a>
                                </div>
                            </div>
                        </div>
                        @empty
                        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; color: #64748b;">
                            <i class="fa-solid fa-calendar-xmark" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.5;"></i>
                            <h3>No Upcoming Workshops</h3>
                            <p>Check back later for new events!</p>
                        </div>
                        @endforelse
                    </div>
                </section>
            </div>

            <!-- Footer -->
            @include('components.footer')
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
</body>

</html>
