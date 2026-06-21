<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- style -->
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/courses.css') }}" />

    <title>Course Explorer | EngHub</title>
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
            <div style="padding: var(--space-2xl);">
                <!-- Page Header -->
                <div class="page-header"
                    style="background: white; border-radius: var(--radius-lg); padding: var(--space-xl); border: 1px solid rgba(0,0,0,0.03); box-shadow: var(--shadow-sm); margin-bottom: var(--space-xl);">
                    <div class="header-content">
                        <h1 style="font-size: 2rem; color: var(--primary-dark); margin-bottom: var(--space-xs);">Courses
                            & Materials</h1>
                        <p style="color: var(--text-muted); font-size: 1rem;">Browse engineering courses, summaries,
                            PDFs, and learning resources.


                        </p>
                    </div>
                </div>

                <!-- Filters -->
                <div class="filter-section"
                    style="background: white; padding: var(--space-lg); border-radius: var(--radius-lg); border: 1px solid rgba(0,0,0,0.03); margin-bottom: var(--space-xl);">
                    <div
                        style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-md);">
                        <div style="display: flex; gap: var(--space-sm); flex-wrap: wrap;">
                            <div
                                style="display: flex; background: var(--bg-main); padding: 4px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                                <button class="btn btn-outline"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; background: transparent; color: var(--text-secondary);">All
                                    Years</button>
                                <button class="btn btn-primary"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; box-shadow: none;">Year
                                    1</button>
                                <button class="btn btn-outline"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; background: transparent; color: var(--text-secondary);">Year
                                    2</button>
                                <button class="btn btn-outline"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; background: transparent; color: var(--text-secondary);">Year
                                    3</button>
                                <button class="btn btn-outline"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; background: transparent; color: var(--text-secondary);">Year
                                    4</button>
                            </div>

                            <div
                                style="display: flex; background: var(--bg-main); padding: 4px; border-radius: var(--radius-md); border: 1px solid var(--border-color);">
                                <button class="btn btn-primary"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; box-shadow: none;">Semester
                                    1</button>
                                <button class="btn btn-outline"
                                    style="border: none; padding: 0.5rem 1rem; border-radius: var(--radius-sm); font-size: 0.85rem; background: transparent; color: var(--text-secondary);">Semester
                                    2</button>
                            </div>
                        </div>

                        <div style="display: flex; gap: var(--space-sm);">
                            <button class="btn btn-outline"
                                style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: var(--radius-md);">
                                <i class="fa-solid fa-sliders"></i>
                                <span>Advanced Filters</span>
                            </button>
                            <button class="btn btn-outline"
                                style="padding: 0.5rem 1rem; font-size: 0.85rem; border-radius: var(--radius-md);">
                                <i class="fa-solid fa-arrow-down-wide-short"></i>
                                <span>Sort: Popular</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Course Grid -->
                <div class="course-grid">
                    <!-- Course 1 -->
                    <div class="course-main-card">
                        <div class="course-card-body">
                            <div class="course-icon" style="color: #3b82f6; background-color: rgba(59, 130, 246, 0.1);">
                                <i class="fa-solid fa-bolt"></i>
                            </div>
                            <div class="course-info">
                                <span class="course-code" style="color: #3b82f6;">EE201</span>
                                <h4>Circuits I</h4>
                                <p>Fundamental principles of electrical circuits, Ohm's Law, Kirchhoff's Laws, and
                                    network theorems.</p>
                                <div
                                    style="display: flex; align-items: center; justify-content: space-between; margin-top: var(--space-md);">
                                    <div
                                        style="display: flex; align-items: center; gap: 4px; font-size: 0.85rem; font-weight: 600;">
                                        <i class="fa-solid fa-star" style="color: #f59e0b;"></i>
                                        <span>4.8 <span style="color: var(--text-muted); font-weight: 400;">(124
                                                ratings)</span></span>
                                    </div>
                                    <div style="display: flex; -webkit-box-align: center; align-items: center;">
                                        <div style="display: flex; margin-right: -8px;">
                                            <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=50&auto=format&fit=crop"
                                                style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; object-fit: cover;" />
                                            <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?q=80&w=50&auto=format&fit=crop"
                                                style="width: 24px; height: 24px; border-radius: 50%; border: 2px solid white; object-fit: cover; margin-left: -8px;" />
                                        </div>
                                        <span
                                            style="font-size: 0.75rem; font-weight: 700; color: var(--primary); background: var(--primary-light); padding: 2px 6px; border-radius: 10px; margin-left: var(--space-xs);">+12</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="course-card-footer"
                            style="display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 0.8rem; color: var(--text-secondary); font-weight: 600;">85%
                                Popularity</span>
                            <span style="font-size: 0.8rem; color: var(--text-muted);"><i
                                    class="fa-regular fa-folder-open"
                                    style="margin-right: 4px; color: var(--primary);"></i> 32 Resources</span>
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
