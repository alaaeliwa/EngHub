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
                            Welcome Back, Alex Rivera 👋</h1>
                        <p
                            style="font-size: 1.1rem; opacity: 0.9; max-width: 600px; font-weight: 300; line-height: 1.6;">
                            Here is a overview of your academic stats and recommendations for your current semester of
                            <strong style="font-weight: 700; color: var(--secondary-light);">Mechanical
                                Engineering</strong>.
                        </p>
                    </div>
                    <!-- decorative shape overlay -->
                    <div
                        style="position: absolute; right: -50px; bottom: -50px; width: 250px; height: 250px; background: rgba(255,255,255,0.05); border-radius: 50%;">
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
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">Semester
                                Courses</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: var(--primary-light); display: flex; align-items: center; justify-content: center; color: var(--primary);">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">5 Active
                        </h3>
                    </div>

                    <div class="card"
                        style="padding: var(--space-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-xs);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                            <span
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">Shared
                                Resources</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: rgba(241, 130, 45, 0.1); display: flex; align-items: center; justify-content: center; color: var(--secondary);">
                                <i class="fa-solid fa-cloud-arrow-up"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">14 Files
                        </h3>
                    </div>

                    <div class="card"
                        style="padding: var(--space-lg); border-radius: var(--radius-md); box-shadow: var(--shadow-xs);">
                        <div
                            style="display: flex; justify-content: space-between; align-items: center; margin-bottom: var(--space-sm);">
                            <span
                                style="font-weight: 700; font-size: 0.85rem; color: var(--text-secondary); text-transform: uppercase;">Attended
                                Workshops</span>
                            <div
                                style="width: 36px; height: 36px; border-radius: 50%; background: rgba(59, 130, 246, 0.1); display: flex; align-items: center; justify-content: center; color: #3b82f6;">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                        </div>
                        <h3 style="font-size: 2rem; font-weight: 800; color: var(--primary-dark); margin: 0;">3 Enrolled
                        </h3>
                    </div>
                </div>

                <!-- Two Column Details Section -->
                <div style="display: grid; grid-template-columns: 2fr 1fr; gap: var(--space-xl); align-items: start;">

                    <!-- Left Column -->
                    <div style="display: flex; flex-direction: column; gap: var(--space-xl);">

                        <!-- Current Semester Courses (Year 3 - Semester 1) -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <h2
                                style="font-size: 1.35rem; color: var(--primary-dark); margin-bottom: var(--space-md); border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm); display: flex; justify-content: space-between; align-items: center;">
                                <span><i class="fa-solid fa-graduation-cap"
                                        style="color: var(--primary); margin-right: var(--space-sm);"></i>Year 3 -
                                    Semester 1 Courses</span>
                                <span
                                    style="font-size: 0.85rem; background: var(--primary-light); color: var(--primary); padding: 4px 10px; border-radius: var(--radius-full); font-weight: 700;">Active
                                    Semester</span>
                            </h2>

                            <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #fafbfc;">
                                    <div style="display: flex; gap: var(--space-md); align-items: center;">
                                        <div
                                            style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(6, 111, 108, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                            ME301</div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1.05rem; color: var(--primary-dark);">
                                                Fluid Mechanics</h4>
                                            <span style="font-size: 0.8rem; color: var(--text-muted);">32 Lecture Notes
                                                • 5 Exam Papers</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: var(--radius-sm);">Explore</button>
                                </div>

                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #fafbfc;">
                                    <div style="display: flex; gap: var(--space-md); align-items: center;">
                                        <div
                                            style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(6, 111, 108, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                            ME302</div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1.05rem; color: var(--primary-dark);">
                                                Thermodynamics II</h4>
                                            <span style="font-size: 0.8rem; color: var(--text-muted);">24 Lecture Notes
                                                • 4 Workshops</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: var(--radius-sm);">Explore</button>
                                </div>

                                <div
                                    style="display: flex; justify-content: space-between; align-items: center; padding: var(--space-md); border: 1px solid var(--border-color); border-radius: var(--radius-md); background: #fafbfc;">
                                    <div style="display: flex; gap: var(--space-md); align-items: center;">
                                        <div
                                            style="width: 40px; height: 40px; border-radius: var(--radius-md); background: rgba(6, 111, 108, 0.1); color: var(--primary); display: flex; align-items: center; justify-content: center; font-weight: 800;">
                                            ME303</div>
                                        <div>
                                            <h4 style="margin: 0; font-size: 1.05rem; color: var(--primary-dark);">
                                                Machine Design I</h4>
                                            <span style="font-size: 0.8rem; color: var(--text-muted);">48 Lecture Notes
                                                • 8 Project Templates</span>
                                        </div>
                                    </div>
                                    <button class="btn btn-outline"
                                        style="padding: 0.4rem 0.8rem; font-size: 0.8rem; border-radius: var(--radius-sm);">Explore</button>
                                </div>
                            </div>
                        </div>

                        <!-- Recent Activities -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <h2
                                style="font-size: 1.35rem; color: var(--primary-dark); margin-bottom: var(--space-md); border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm);">
                                <i class="fa-solid fa-clock-rotate-left"
                                    style="color: var(--primary); margin-right: var(--space-sm);"></i>Recent Activities
                            </h2>
                            <div style="display: flex; flex-direction: column; gap: var(--space-md);">
                                <div
                                    style="display: flex; gap: var(--space-md); align-items: center; padding: var(--space-sm) 0;">
                                    <div
                                        style="width: 8px; height: 8px; border-radius: 50%; background: var(--secondary);">
                                    </div>
                                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-secondary);">You
                                        downloaded <strong>Fluid Mechanics Exam 2024 Solution</strong></p>
                                    <span style="margin-left: auto; font-size: 0.8rem; color: var(--text-muted);">2
                                        hours ago</span>
                                </div>
                                <div
                                    style="display: flex; gap: var(--space-md); align-items: center; padding: var(--space-sm) 0;">
                                    <div
                                        style="width: 8px; height: 8px; border-radius: 50%; background: var(--primary);">
                                    </div>
                                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-secondary);">You
                                        uploaded <strong>Dynamics Lecture 4 Handwritten Summary</strong></p>
                                    <span
                                        style="margin-left: auto; font-size: 0.8rem; color: var(--text-muted);">Yesterday</span>
                                </div>
                                <div
                                    style="display: flex; gap: var(--space-md); align-items: center; padding: var(--space-sm) 0;">
                                    <div style="width: 8px; height: 8px; border-radius: 50%; background: #3b82f6;">
                                    </div>
                                    <p style="margin: 0; font-size: 0.95rem; color: var(--text-secondary);">You
                                        registered for <strong>Intro to SolidWorks & 3D Printing</strong> workshop</p>
                                    <span style="margin-left: auto; font-size: 0.8rem; color: var(--text-muted);">3
                                        days ago</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div style="display: flex; flex-direction: column; gap: var(--space-xl);">


                        <!-- Upcoming Workshops -->
                        <div class="card" style="box-shadow: var(--shadow-sm); padding: var(--space-xl);">
                            <h2
                                style="font-size: 1.25rem; color: var(--primary-dark); margin-bottom: var(--space-md); border-bottom: 2px solid var(--border-light); padding-bottom: var(--space-sm);">
                                <i class="fa-solid fa-laptop-code"
                                    style="color: var(--primary); margin-right: var(--space-sm);"></i>Upcoming
                                Workshops
                            </h2>
                            <div style="display: flex; flex-direction: column; gap: var(--space-lg);">
                                <div style="border-left: 3px solid var(--secondary); padding-left: var(--space-sm);">
                                    <h4 style="margin: 0; font-size: 0.95rem; color: var(--primary-dark);">SolidWorks
                                        Advanced Modeling</h4>
                                    <span
                                        style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;"><i
                                            class="fa-regular fa-calendar-days"
                                            style="margin-right: 4px;"></i>Tomorrow, 17:00</span>
                                </div>
                                <div style="border-left: 3px solid #3b82f6; padding-left: var(--space-sm);">
                                    <h4 style="margin: 0; font-size: 0.95rem; color: var(--primary-dark);">Finite
                                        Element Analysis (FEA) Intro</h4>
                                    <span
                                        style="display: block; font-size: 0.75rem; color: var(--text-muted); margin-top: 2px;"><i
                                            class="fa-regular fa-calendar-days" style="margin-right: 4px;"></i>June
                                        25, 14:00</span>
                                </div>
                            </div>
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
