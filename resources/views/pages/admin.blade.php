<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="EngHub Admin Dashboard - Manage users, courses, workshops, materials and platform settings." />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/admin.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/upload-materials.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/create-workshop.css') }}" />
    <title>Admin Dashboard | EngHub</title>
</head>

<body>



    <div class="admin-layout">
        <!-- Premium Admin Header -->
        <header class="admin-header">
            <div class="container">
                <div class="header-top">
                    <div class="header-left">
                        <a href="{{ route('admin') }}" class="admin-logo">
                            <img src="\logo.png" alt="EngHub logo" />
                            <span class="logo-tag">Admin</span>
                        </a>
                    </div>

                    <div class="header-right">
                        <div class="admin-date" id="adminDate"></div>
                        <div class="header-actions">
                            <div class="notification-wrapper" style="position: relative;">
                                <button class="btn-icon notification-btn" id="notificationBtn">
                                    <i class="fa-solid fa-bell"></i>
                                    <span class="notification-badge">3</span>
                                </button>

                                <div class="notification-dropdown" id="notificationDropdown">
                                    <div class="dropdown-header">
                                        <h4>Notifications</h4>
                                        <span class="mark-read">Mark all as read</span>
                                    </div>
                                    <div class="dropdown-body">
                                        <div class="notification-item unread">
                                            <div class="notif-icon"
                                                style="background: rgba(16, 185, 129, 0.1); color: #10b981;"><i
                                                    class="fa-solid fa-user-plus"></i></div>
                                            <div class="notif-content">
                                                <p><strong>Ahmad Ali</strong> registered as a new user.</p>
                                                <span class="notif-time">2 mins ago</span>
                                            </div>
                                        </div>
                                        <div class="notification-item unread">
                                            <div class="notif-icon"
                                                style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;"><i
                                                    class="fa-solid fa-calendar-check"></i></div>
                                            <div class="notif-content">
                                                <p>New workshop <strong>"React Basics"</strong> pending approval.</p>
                                                <span class="notif-time">1 hour ago</span>
                                            </div>
                                        </div>
                                        <div class="notification-item">
                                            <div class="notif-icon"
                                                style="background: rgba(59, 130, 246, 0.1); color: #3b82f6;"><i
                                                    class="fa-solid fa-cloud-arrow-up"></i></div>
                                            <div class="notif-content">
                                                <p><strong>Sara Khaled</strong> uploaded a new material in Software Eng.
                                                </p>
                                                <span class="notif-time">5 hours ago</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="dropdown-footer">
                                        <a href="{{ route('notifications.index') }}">View All Notifications</a>
                                    </div>
                                </div>
                            </div>
                            <div class="admin-user">
                                <div class="user-info">
                                    <span class="user-name">{{ Auth::user()->first_name }}
                                        {{ Auth::user()->last_name }}</span>
                                    <span class="user-role">Platform Manager</span>
                                </div>
                                <div class="user-avatar">
                                    <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&background=066f6c&color=fff' }}"
                                        alt="Admin Avatar" />
                                </div>
                            </div>
                            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                                @csrf
                                <button type="submit" class="admin-logout" title="Logout"
                                    style="background: none; border: none; cursor: pointer; padding: 0;">
                                    <i class="fa-solid fa-right-from-bracket"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <nav class="admin-nav-bar">
                    <div class="admin-tabs">
                        <button class="admin-tab active" data-tab="overview"><i class="fa-solid fa-chart-line"></i>
                            <span>Overview</span></button>
                        <button class="admin-tab" data-tab="users"><i class="fa-solid fa-users"></i> <span>Users</span>
                            <span class="tab-badge">{{ $stats['total_users'] }}</span></button>
                        <button class="admin-tab" data-tab="courses"><i class="fa-solid fa-book"></i>
                            <span>Courses</span> <span class="tab-badge">{{ $stats['total_courses'] }}</span></button>
                        <button class="admin-tab" data-tab="materials"><i class="fa-solid fa-file-lines"></i>
                            <span>Materials</span>
                            @php $pendingMaterials = $materials->where('status', 'pending')->count(); @endphp
                            @if ($pendingMaterials > 0)
                                <span class="tab-badge"
                                    style="background:#ef4444; color:white;">{{ $pendingMaterials }}</span>
                            @else
                                <span class="tab-badge">{{ $stats['total_materials'] }}</span>
                            @endif
                        </button>
                        <button class="admin-tab" data-tab="workshops"><i class="fa-solid fa-calendar-days"></i>
                            <span>Workshops</span> <span
                                class="tab-badge">{{ $stats['total_workshops'] }}</span></button>
                        <button class="admin-tab" data-tab="comments"><i class="fa-solid fa-comments"></i>
                            <span>Comments</span></button>
                        <button class="admin-tab" data-tab="departments"><i class="fa-solid fa-building"></i>
                            <span>Departments</span></button>
                        <button class="admin-tab" data-tab="settings"><i class="fa-solid fa-gear"></i>
                            <span>Settings</span></button>
                    </div>
                </nav>
            </div>
        </header>

        <!-- Main Content -->
        <main class="admin-main">
            <div class="container">
                <div id="panel-overview" class="tab-panel active">
                    <!-- Welcome -->
                    <section class="admin-welcome animate-in">
                        <div class="welcome-flex">
                            <div class="welcome-text">
                                <h1>Admin Control Center 🛡️</h1>
                                <p>Manage and monitor the entire EngHub platform from here.</p>
                            </div>
                            <div class="quick-actions">
                                <button class="btn-action-glass" onclick="openModal('uploadMaterialModal')"><i
                                        class="fa-solid fa-cloud-arrow-up"></i> Upload Material</button>
                            </div>
                        </div>
                    </section>

                    <!-- Stats (Real data from DB) -->
                    <div class="stats-grid animate-in">
                        <div class="stat-card">
                            <div class="stat-icon users"><i class="fa-solid fa-users"></i></div>
                            <div class="stat-info">
                                <h4>{{ number_format($stats['total_users']) }}</h4>
                                <p>Total Users</p>
                                <span class="stat-trend up">{{ $stats['active_users'] }} active ·
                                    {{ $stats['banned_users'] }} banned</span>
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon courses"><i class="fa-solid fa-book-open"></i></div>
                            <div class="stat-info">
                                <h4>{{ number_format($stats['total_courses']) }}</h4>
                                <p>Total Courses</p>
                                @if ($stats['pending_courses'] > 0)
                                    <span class="stat-trend down">{{ $stats['pending_courses'] }} pending
                                        review</span>
                                @else
                                    <span class="stat-trend up">All courses approved</span>
                                @endif
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon workshops"><i class="fa-solid fa-file-lines"></i></div>
                            <div class="stat-info">
                                <h4>{{ number_format($stats['total_materials']) }}</h4>
                                <p>Total Materials</p>
                                @if ($stats['pending_materials'] > 0)
                                    <span class="stat-trend down">{{ $stats['pending_materials'] }} pending
                                        review</span>
                                @else
                                    <span class="stat-trend up">All materials reviewed</span>
                                @endif
                            </div>
                        </div>
                        <div class="stat-card">
                            <div class="stat-icon reports"><i class="fa-solid fa-calendar-check"></i></div>
                            <div class="stat-info">
                                <h4>{{ number_format($stats['total_workshops']) }}</h4>
                                <p>Total Workshops</p>
                                <span class="stat-trend up">{{ $stats['student_users'] }} students ·
                                    {{ $stats['instructor_users'] }} instructors</span>
                            </div>
                        </div>
                    </div>

                    <div class="overview-grid">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Platform Activity</h3>
                                <select class="filter-select" id="chartPeriod">
                                    <option>Last 7 days</option>
                                    <option>Last 30 days</option>
                                    <option>This year</option>
                                </select>
                            </div>
                            <div class="chart-body" id="activityChart"></div>
                        </div>
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Recent Activity</h3>
                            </div>
                            <div class="recent-list">
                                @forelse($recentUsers as $ru)
                                    <div class="recent-item">
                                        <div class="recent-icon" style="background:#eff6ff; color:#2563eb;">
                                            <i class="fa-solid fa-user-plus"></i>
                                        </div>
                                        <div class="recent-content">
                                            <p><strong>{{ $ru->first_name }} {{ $ru->last_name }}</strong> joined as
                                                {{ ucfirst($ru->role) }}</p>
                                            <span class="recent-time">{{ $ru->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p style="color:#64748b; padding:1rem;">No recent users.</p>
                                @endforelse
                                @foreach ($recentMaterials as $rm)
                                    <div class="recent-item">
                                        <div class="recent-icon" style="background:#f0fdf4; color:#16a34a;">
                                            <i class="fa-solid fa-file-arrow-up"></i>
                                        </div>
                                        <div class="recent-content">
                                            <p>New material uploaded: <strong>{{ $rm->title }}</strong></p>
                                            <span class="recent-time">{{ $rm->created_at->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="overview-grid">
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Users by Department</h3>
                            </div>
                            <div class="chart-body" id="deptChart"></div>
                        </div>
                        <div class="chart-card">
                            <div class="chart-header">
                                <h3>Top Courses</h3>
                            </div>
                            <div class="recent-list">
                                @forelse($topCoursesList as $i => $c)
                                    <div class="recent-item">
                                        @php
                                            $bg =
                                                $i === 0
                                                    ? '#fffbeb'
                                                    : ($i === 1
                                                        ? '#f8fafc'
                                                        : ($i === 2
                                                            ? '#fff7ed'
                                                            : '#f1f5f9'));
                                            $color =
                                                $i === 0
                                                    ? '#d97706'
                                                    : ($i === 1
                                                        ? '#64748b'
                                                        : ($i === 2
                                                            ? '#c2410c'
                                                            : '#94a3b8'));
                                            $icon = $i < 3 ? 'fa-trophy' : 'fa-book';
                                        @endphp
                                        <div class="recent-icon"
                                            style="background:{{ $bg }};color:{{ $color }}">
                                            <i class="fa-solid {{ $icon }}"></i>
                                        </div>
                                        <div class="recent-content">
                                            <p><strong>{{ $c->title }}</strong></p>
                                            <span class="recent-time">{{ $c->code }} •
                                                {{ ucfirst($c->status) }}</span>
                                        </div>
                                    </div>
                                @empty
                                    <p style="color:#64748b; padding:1rem;">No courses yet.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>


                </div>

                <!-- ═══ USERS TAB ═══ -->
                <div class="tab-panel" id="panel-users">
                    <div class="panel-header">
                        <h2>User Management</h2>
                        <div class="panel-actions">
                            <div class="search-wrap">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" class="search-input" placeholder="Search users..."
                                    id="searchUsers" />
                            </div>
                            <select class="filter-select" id="filterRole">
                                <option value="all">All Roles</option>
                                <option value="student">Student</option>
                                <option value="instructor">Instructor</option>
                                <option value="admin">Admin</option>
                            </select>
                            <select class="filter-select" id="filterStatus">
                                <option value="all">All Status</option>
                                <option value="active">Active</option>
                                <option value="banned">Banned</option>
                            </select>
                        </div>
                    </div>
                    <div class="data-table-wrap">
                        <table class="data-table" id="usersTable">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Department</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="usersBody">
                                @forelse($users as $u)
                                    <tr id="user-row-{{ $u->id }}" data-role="{{ strtolower($u->role) }}"
                                        data-status="{{ strtolower($u->status) }}"
                                        data-search="{{ strtolower($u->name . ' ' . $u->email) }}">
                                        <td>
                                            <div class="table-user">
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background={{ $u->role === 'admin' ? '1e293b' : ($u->role === 'instructor' ? '16a34a' : '066f6c') }}&color=fff&size=36"
                                                    alt="{{ $u->name }}" />
                                                <div class="table-user-info"><strong
                                                        id="user-name-{{ $u->id }}">{{ $u->name }}</strong><span>ID:
                                                        {{ $u->id }}</span></div>
                                            </div>
                                        </td>
                                        <td id="user-email-{{ $u->id }}">{{ $u->email }}</td>
                                        <td><span id="user-role-badge-{{ $u->id }}"
                                                class="badge badge-{{ $u->role }}">{{ ucfirst($u->role) }}</span>
                                        </td>
                                        <td>{{ $u->dept }}</td>
                                        <td><span id="user-status-badge-{{ $u->id }}"
                                                class="badge badge-{{ $u->status }}">{{ ucfirst($u->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="action-btn edit" title="Edit"
                                                    onclick="editUser({{ $u->id }})"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="action-btn ban" title="Ban / Unban"
                                                    onclick="toggleBanUser({{ $u->id }})"><i
                                                        id="ban-icon-{{ $u->id }}"
                                                        class="fa-solid fa-{{ $u->status === 'banned' ? 'lock-open' : 'ban' }}"></i></button>
                                                <button class="action-btn delete" title="Delete"
                                                    onclick="deleteUser({{ $u->id }})"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#64748b;">No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination" id="usersPagination"></div>
                    </div>
                </div>

                <!-- ═══ COURSES TAB ═══ -->
                <div class="tab-panel" id="panel-courses">
                    <div class="panel-header">
                        <h2>Course Management</h2>
                        <div class="panel-actions">
                            <div class="search-wrap">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" class="search-input" placeholder="Search courses..."
                                    id="searchCourses" />
                            </div>
                            <select class="filter-select" id="filterCourseStatus">
                                <option value="all">All Status</option>
                                <option value="approved">Approved</option>
                                <option value="pending">Pending</option>
                                <option value="rejected">Rejected</option>
                            </select>
                            <button class="btn" onclick="openAddCourseModal()"
                                style="padding: 0.5rem 1.2rem; font-size:0.9rem;">
                                <i class="fa-solid fa-plus" style="margin-right:6px;"></i> Add Course
                            </button>
                        </div>
                    </div>
                    <div class="data-table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Course</th>
                                    <th>Instructor</th>
                                    <th>Year</th>
                                    <th>Semester</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="coursesBody">
                                @forelse($courses as $c)
                                    <tr id="course-row-{{ $c->id }}"
                                        data-status="{{ strtolower($c->status) }}"
                                        data-search="{{ strtolower($c->title . ' ' . $c->code . ' ' . $c->instructor) }}">
                                        <td><strong
                                                style="color:var(--primary-dark)">{{ $c->title }}</strong><br><small
                                                style="color:#64748b">{{ $c->code }}</small></td>
                                        <td>{{ $c->instructor ?? '—' }}</td>
                                        <td><span class="badge"
                                                style="background:#eff6ff;color:#1d4ed8;border:1px solid #bfdbfe;">Year
                                                {{ $c->year }}</span></td>
                                        <td><span class="badge"
                                                style="background:#f0fdf4;color:#15803d;border:1px solid #bbf7d0;">Sem
                                                {{ $c->semester }}</span></td>
                                        <td><span id="course-status-badge-{{ $c->id }}"
                                                class="badge badge-{{ $c->status }}">{{ ucfirst($c->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="action-btns" id="course-actions-{{ $c->id }}">
                                                @if ($c->status === 'pending')
                                                    <button class="action-btn approve" title="Approve"
                                                        onclick="changeCourseStatus({{ $c->id }}, 'approved')"><i
                                                            class="fa-solid fa-check"></i></button>
                                                    <button class="action-btn ban" title="Reject"
                                                        onclick="changeCourseStatus({{ $c->id }}, 'rejected')"><i
                                                            class="fa-solid fa-xmark"></i></button>
                                                @endif
                                                <button class="action-btn delete" title="Delete"
                                                    onclick="deleteCourse({{ $c->id }})"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#64748b; padding:2rem;">No
                                            courses found. Click "Add Course" to get started.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination" id="coursesPagination"></div>
                    </div>
                </div>

                <!-- ═══ MATERIALS TAB ═══ -->
                <div class="tab-panel" id="panel-materials">
                    <div class="panel-header">
                        <h2>Materials Management</h2>
                        <div class="panel-actions">
                            <div class="search-wrap">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" class="search-input" placeholder="Search materials..."
                                    id="searchMaterials" />
                            </div>
                            <select class="filter-select" id="filterMaterialType">
                                <option value="all">All Types</option>
                                <option value="pdf">PDF</option>
                                <option value="video">Video</option>
                                <option value="summary">Summary</option>
                                <option value="link">Link</option>
                            </select>
                        </div>
                    </div>
                    <div class="data-table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Material</th>
                                    <th>Type</th>
                                    <th>Uploaded By</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="materialsBody">
                                @forelse($materials as $m)
                                    @php
                                        $typeIcons = [
                                            'pdf' => 'fa-file-pdf',
                                            'video' => 'fa-video',
                                            'summary' => 'fa-file-lines',
                                            'link' => 'fa-link',
                                        ];
                                        $typeColors = [
                                            'pdf' => '#dc2626',
                                            'video' => '#0284c7',
                                            'summary' => '#16a34a',
                                            'link' => '#7c3aed',
                                        ];
                                        $icon = $typeIcons[$m->type] ?? 'fa-file';
                                        $color = $typeColors[$m->type] ?? '#64748b';
                                    @endphp
                                    <tr id="material-row-{{ $m->id }}" data-type="{{ strtolower($m->type) }}"
                                        data-search="{{ strtolower($m->title . ' ' . $m->course . ' ' . $m->uploader) }}">
                                        <td><strong style="color:var(--primary-dark)">{{ $m->title }}</strong>
                                        </td>
                                        <td><i class="fa-solid {{ $icon }}"
                                                style="color:{{ $color }};margin-right:0.4rem"></i>{{ ucfirst($m->type) }}
                                        </td>
                                        <td>{{ $m->uploader }}</td>
                                        <td>{{ $m->course }}</td>
                                        <td>{{ $m->date }}</td>
                                        <td><span id="material-status-badge-{{ $m->id }}"
                                                class="badge badge-{{ $m->status }}">{{ ucfirst($m->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="action-btns" id="material-actions-{{ $m->id }}">
                                                <button class="action-btn view" title="Preview"
                                                    onclick="window.open('{{ asset('storage/' . $m->file_path) }}', '_blank')"><i
                                                        class="fa-solid fa-eye"></i></button>
                                                @if ($m->status === 'pending')
                                                    <button class="action-btn approve" title="Approve"
                                                        onclick="changeMaterialStatus({{ $m->id }}, 'approved')"><i
                                                            class="fa-solid fa-check"></i></button>
                                                    <button class="action-btn ban" title="Reject"
                                                        onclick="changeMaterialStatus({{ $m->id }}, 'rejected')"><i
                                                            class="fa-solid fa-xmark"></i></button>
                                                @endif
                                                <button class="action-btn delete" title="Delete"
                                                    onclick="deleteMaterial({{ $m->id }})"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" style="text-align:center; color:#64748b;">No materials
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination" id="materialsPagination"></div>
                    </div>
                </div>

                <!-- ═══ WORKSHOPS TAB ═══ -->
                <div class="tab-panel" id="panel-workshops">
                    <div class="panel-header">
                        <h2>Workshop Management</h2>
                        <div class="panel-actions">
                            <div class="search-wrap">
                                <i class="fa-solid fa-magnifying-glass"></i>
                                <input type="text" class="search-input" placeholder="Search workshops..."
                                    id="searchWorkshops" />
                            </div>
                            <button class="btn btn-primary sm" id="addWorkshopBtn"><i class="fa-solid fa-plus"></i>
                                Add Workshop</button>
                        </div>
                    </div>
                    <div class="data-table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Workshop</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Registered</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($workshops as $w)
                                    <tr>
                                        <td><strong style="color:var(--primary-dark)">{{ $w->title }}</strong>
                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($w->date)->format('M d, Y g:i A') }}</td>
                                        <td>{{ $w->location }}</td>
                                        <td>{{ $w->registered }}</td>
                                        <td><span
                                                class="badge badge-{{ $w->status }}">{{ ucfirst($w->status) }}</span>
                                        </td>
                                        <td>
                                            <div class="action-btns">
                                                @if ($w->status === 'pending')
                                                    <button class="action-btn approve" title="Approve"
                                                        onclick="changeWorkshopStatus({{ $w->id }}, 'approved')"><i
                                                            class="fa-solid fa-check"></i></button>
                                                    <button class="action-btn ban" title="Reject"
                                                        onclick="changeWorkshopStatus({{ $w->id }}, 'rejected')"><i
                                                            class="fa-solid fa-xmark"></i></button>
                                                @endif
                                                <button class="action-btn view" title="View"
                                                    onclick="window.location.href='{{ route('workshop-details', $w->id) }}?admin=1'"><i
                                                        class="fa-solid fa-eye"></i></button>
                                                <button class="action-btn edit" title="Edit"
                                                    onclick="window.location.href='{{ route('admin.workshops.edit', $w->id) }}?admin=1'"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="action-btn delete" title="Delete"
                                                    onclick="deleteWorkshop({{ $w->id }})"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#64748b;">No workshops
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="pagination" id="workshopsPagination"></div>
                    </div>
                </div>

                <!-- ═══ COMMENTS TAB ═══ -->
                <div class="tab-panel" id="panel-comments">
                    <div class="panel-header">
                        <h2>Comments & Reports</h2>
                    </div>
                    <div class="data-table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>User</th>
                                    <th>Comment</th>
                                    <th>Course</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody id="commentsBodyNative">
                                @forelse($comments as $c)
                                    <tr>
                                        <td><strong>{{ $c->user->first_name ?? '' }} {{ $c->user->last_name ?? '' }}</strong></td>
                                        <td style="max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;" title="{{ $c->body }}">
                                            {{ $c->body }}
                                        </td>
                                        <td>{{ $c->course->title ?? 'N/A' }}</td>
                                        <td>{{ $c->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="action-btn delete" title="Delete Comment" onclick="deleteCommentDB({{ $c->id }}, this)"><i class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:#64748b;">No comments found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ═══ DEPARTMENTS TAB ═══ -->
                <div class="tab-panel" id="panel-departments">
                    <div class="panel-header">
                        <h2>Departments & Subjects</h2>
                        <div class="panel-actions">
                            <button class="btn btn-primary sm" id="addDeptBtn"><i class="fa-solid fa-plus"></i> Add
                                Department</button>
                        </div>
                    </div>
                    <div class="data-table-wrap">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Department</th>
                                    <th>Students</th>
                                    <th>Courses</th>
                                    <th>Years</th>
                                    <th>Subjects</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($departments as $d)
                                    <tr>
                                        <td><strong style="color:var(--primary-dark)">{{ $d->name }}</strong>
                                        </td>
                                        <td>{{ $d->students }}</td>
                                        <td>{{ $d->courses }}</td>
                                        <td>{{ $d->years }}</td>
                                        <td>{{ $d->subjects }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="action-btn edit" title="Edit"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="action-btn delete" title="Delete"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" style="text-align:center; color:#64748b;">No departments
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ═══ SETTINGS TAB ═══ -->
                <div class="tab-panel" id="panel-settings">
                    <div class="panel-header">
                        <h2>Platform Configuration</h2>
                    </div>
                    <div class="data-table-wrap" style="padding: 2.5rem; background: white;">
                        <div class="settings-grid">
                            <div class="settings-section">
                                <h3 style="color:var(--primary-dark); margin-bottom:1.5rem; font-weight:800;"><i
                                        class="fa-solid fa-sliders"
                                        style="color:var(--primary); margin-right:10px;"></i> General Settings</h3>
                                <div class="form-group">
                                    <label>Platform Name</label>
                                    <input type="text" value="EngHub" />
                                </div>
                                <div class="form-group">
                                    <label>Platform Description</label>
                                    <textarea rows="3">Engineering the Future, Together. A collaborative platform for engineering students.</textarea>
                                </div>
                            </div>

                            <div class="settings-section">
                                <h3 style="color:var(--primary-dark); margin-bottom:1.5rem; font-weight:800;"><i
                                        class="fa-solid fa-shield-halved"
                                        style="color:var(--secondary); margin-right:10px;"></i> Security & Access</h3>
                                <div class="form-group">
                                    <div class="toggle-group">
                                        <div class="toggle-text">
                                            <strong>Allow Student Uploads</strong>
                                            <span>Enable students to submit courses</span>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="toggle-group">
                                        <div class="toggle-text">
                                            <strong>Email Verification</strong>
                                            <span>Require email confirmation for new users</span>
                                        </div>
                                        <label class="switch">
                                            <input type="checkbox" checked>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="settings-section full-width"
                                style="border-top: 1px solid #f1f5f9; padding-top: 2rem; margin-top: 1rem;">
                                <h3 style="color:var(--primary-dark); margin-bottom:1.5rem; font-weight:800;"><i
                                        class="fa-solid fa-gears" style="color:#7c3aed; margin-right:10px;"></i>
                                    System Behavior</h3>
                                <div class="grid-2">
                                    <div class="form-group">
                                        <label>Auto-approve Materials</label>
                                        <select>
                                            <option>Disabled</option>
                                            <option>Enabled</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label>Support Email Address</label>
                                        <input type="email" value="support@enghub.edu" />
                                    </div>
                                </div>
                                <div style="display:flex; gap:1rem; margin-top:2rem;">
                                    <button class="btn-save" onclick="showToast('Settings saved successfully!')">Save
                                        All Changes</button>
                                    <button class="btn-cancel">Reset Defaults</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </main>
    </div>

    <!-- Edit User Modal -->
    <div class="modal-overlay" id="editUserModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fa-solid fa-user-pen"></i> Edit User</h3>
                <button class="modal-close" onclick="closeModal('editUserModal')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <div class="form-group"><label>Full Name</label><input type="text" id="editName" /></div>
            <div class="form-group"><label>Email</label><input type="email" id="editEmail" /></div>
            <div class="form-group">
                <label>Role</label>
                <select id="editRole">
                    <option value="student">Student</option>
                    <option value="instructor">Instructor</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select id="editStatus">
                    <option value="active">Active</option>
                    <option value="banned">Banned</option>
                </select>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('editUserModal')">Cancel</button>
                <button class="btn-save" onclick="saveUser()">Save Changes</button>
            </div>
        </div>
    </div>

    <!-- Delete Confirm Modal -->
    <div class="modal-overlay" id="deleteModal">
        <div class="modal">
            <div class="modal-header">
                <h3><i class="fa-solid fa-triangle-exclamation" style="color:#dc2626"></i> Confirm Delete</h3>
                <button class="modal-close" onclick="closeModal('deleteModal')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <p style="color:#64748b;margin-bottom:1.5rem;" id="deleteMsg">Are you sure you want to delete this item?
                This action cannot be undone.</p>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeModal('deleteModal')">Cancel</button>
                <button class="btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
        </div>
    </div>

    <!-- Upload Material Modal -->
    <div class="modal-overlay" id="uploadMaterialModal">
        <div class="modal"
            style="max-width: 650px; padding: 0; overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;">
            <div class="modal-header"
                style="padding: 2rem 2.5rem 1.5rem; margin: 0; background-color: #fafbfc; border-bottom: 1px solid #f1f5f9; flex-shrink: 0;">
                <h3 style="margin: 0; font-size: 1.5rem;"><i class="fa-solid fa-cloud-arrow-up"
                        style="color:var(--primary);"></i> Upload Material</h3>
                <button class="modal-close" onclick="closeModal('uploadMaterialModal')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="adminUploadForm"
                onsubmit="event.preventDefault(); showToast('Material uploaded successfully!'); closeModal('uploadMaterialModal');"
                class="modern-upload-form" style="padding: 2rem 2.5rem; overflow-y: auto; flex: 1;">

                <div class="input-group full-width" style="margin-bottom: 1.5rem;">
                    <label>Department <span class="required" style="color:#ef4444">*</span></label>
                    <select required>
                        <option value="">Select Department</option>
                        <option value="se">Software Engineering</option>
                        <option value="ce">Civil Engineering</option>
                        <option value="ee">Electrical Engineering</option>
                        <option value="me">Mechanical Engineering</option>
                    </select>
                </div>

                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    <div class="input-group">
                        <label>Academic Year <span class="required" style="color:#ef4444">*</span></label>
                        <select required>
                            <option value="">Select Year</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <label>Semester <span class="required" style="color:#ef4444">*</span></label>
                        <select required>
                            <option value="">Select Semester</option>
                            <option value="1">1st Semester</option>
                            <option value="2">2nd Semester</option>
                            <option value="summer">Summer Semester</option>
                        </select>
                    </div>
                </div>

                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    <div class="input-group">
                        <label>Course Name <span class="required" style="color:#ef4444">*</span></label>
                        <input type="text" required placeholder="e.g. Data Structures">
                    </div>
                    <div class="input-group">
                        <label>Material Title <span class="required" style="color:#ef4444">*</span></label>
                        <input type="text" required placeholder="e.g. Chapter 3 Summary">
                    </div>
                </div>

                <div class="input-group full-width" style="margin-bottom: 1.5rem;">
                    <label>Material Type <span class="required" style="color:#ef4444">*</span></label>
                    <div class="type-selector">
                        <label class="type-btn">
                            <input type="radio" name="adminMatType" value="pdf" checked>
                            <span><i class="fa-solid fa-file-pdf"></i> Summary</span>
                        </label>
                        <label class="type-btn">
                            <input type="radio" name="adminMatType" value="notes">
                            <span><i class="fa-solid fa-note-sticky"></i> Notes</span>
                        </label>
                        <label class="type-btn">
                            <input type="radio" name="adminMatType" value="exam">
                            <span><i class="fa-solid fa-pen-to-square"></i> Exam Bank</span>
                        </label>
                        <label class="type-btn">
                            <input type="radio" name="adminMatType" value="slides">
                            <span><i class="fa-solid fa-file-powerpoint"></i> Slides</span>
                        </label>
                    </div>
                </div>

                <div class="input-group full-width" style="margin-bottom: 2rem;">
                    <label>Upload File</label>
                    <div class="drop-zone" onclick="document.getElementById('adminFileInput').click()">
                        <i class="fa-solid fa-file-circle-plus"></i>
                        <p>Drag & drop file here or <span>browse</span></p>
                        <small>PDF, DOCX, PPT, or ZIP (Max 20MB)</small>
                        <input type="file" id="adminFileInput" hidden>
                    </div>
                </div>

                <div class="modal-footer"
                    style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; border-top: 1px solid #f1f5f9; padding-top: 2rem;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('uploadMaterialModal')"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: 2px solid #e2e8f0; background: white; color: #64748b; cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn btn-primary"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;"><i
                            class="fa-solid fa-cloud-arrow-up"></i> Upload Now</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Add Workshop Modal -->
    <div class="modal-overlay" id="addWorkshopModal">
        <div class="modal"
            style="max-width: 850px; padding: 0; overflow: hidden; max-height: 90vh; display: flex; flex-direction: column;">
            <div class="modal-header"
                style="padding: 2rem 2.5rem 1.5rem; margin: 0; background-color: #fafbfc; border-bottom: 1px solid #f1f5f9; flex-shrink: 0;">
                <h3 style="margin: 0; font-size: 1.5rem;"><i class="fa-solid fa-calendar-plus"
                        style="color:var(--primary);"></i> Add New Workshop</h3>
                <button class="modal-close" onclick="closeModal('addWorkshopModal')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>

            <form id="adminAddWorkshopForm" onsubmit="event.preventDefault(); saveWorkshop();"
                class="modern-workshop-form" style="padding: 2rem 2.5rem; overflow-y: auto; flex: 1;">

                <h4 style="color:var(--primary-dark); margin-bottom: 1rem;"><i class="fa-solid fa-pen-to-square"></i>
                    Essential Information</h4>
                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    <div class="input-group">
                        <label>Workshop Title <span class="required" style="color:#ef4444">*</span></label>
                        <input type="text" id="newWorkshopTitle" required placeholder="Enter a catchy title...">
                    </div>
                    <div class="input-group">
                        <label>Category <span class="required" style="color:#ef4444">*</span></label>
                        <select id="newWorkshopCategory" required>
                            <option value="">Select Category</option>
                            <option value="programming">Programming</option>
                            <option value="soft-skills">Soft Skills</option>
                            <option value="design">Design</option>
                            <option value="engineering">Engineering Tools</option>
                        </select>
                    </div>
                </div>
                <div class="input-group full-width" style="margin-bottom: 2rem;">
                    <label>Description <span class="required" style="color:#ef4444">*</span></label>
                    <textarea id="newWorkshopDescription" rows="3" placeholder="What will students learn? What are the goals?"
                        required></textarea>
                </div>

                <h4
                    style="color:var(--primary-dark); margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <i class="fa-solid fa-calendar-check"></i> Schedule & Logistics
                </h4>
                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    <div class="input-group">
                        <label>Date <span class="required" style="color:#ef4444">*</span></label>
                        <input type="date" id="newWorkshopDate" required>
                    </div>
                    <div class="input-group">
                        <label>Start Time <span class="required" style="color:#ef4444">*</span></label>
                        <input type="time" id="newWorkshopTime" required>
                    </div>
                </div>
                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    <div class="input-group">
                        <label>Duration (Hours) <span class="required" style="color:#ef4444">*</span></label>
                        <input type="number" id="newWorkshopDuration" placeholder="e.g. 2" required>
                    </div>
                    <div class="input-group">
                        <label>Available Seats <span class="required" style="color:#ef4444">*</span></label>
                        <input type="number" id="newWorkshopSeats" placeholder="e.g. 30" required>
                    </div>
                </div>
                <div class="grid-2" style="margin-bottom: 2rem;">
                    <div class="input-group">
                        <label>Workshop Type <span class="required" style="color:#ef4444">*</span></label>
                        <div class="radio-group" style="display: flex; gap: 1rem; margin-top: 5px;">
                            <label
                                style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #475569; font-weight: 600;">
                                <input type="radio" name="adminLocationType" value="online" checked> Online
                            </label>
                            <label
                                style="display: flex; align-items: center; gap: 8px; cursor: pointer; color: #475569; font-weight: 600;">
                                <input type="radio" name="adminLocationType" value="offline"> Offline
                            </label>
                        </div>
                    </div>
                    <div class="input-group">
                        <label>Meeting Link / Room <span class="required" style="color:#ef4444">*</span></label>
                        <input type="text" id="newWorkshopLocation" placeholder="Enter link or room number..."
                            required>
                    </div>
                </div>

                <h4
                    style="color:var(--primary-dark); margin-bottom: 1rem; padding-top: 1rem; border-top: 1px solid #f1f5f9;">
                    <i class="fa-solid fa-user-tie"></i> Instructor & Media
                </h4>
                <div class="grid-2" style="margin-bottom: 1.5rem;">
                    <div class="input-group">
                        <label>Instructor Name <span class="required" style="color:#ef4444">*</span></label>
                        <input type="text" id="newWorkshopInstructor" placeholder="Full name of the presenter..."
                            required>
                    </div>
                    <div class="input-group">
                        <label>Workshop Banner</label>
                        <div class="upload-area"
                            style="border: 2px dashed #cbd5e1; padding: 1.5rem; text-align: center; border-radius: 8px; background: #f8fafc; cursor: pointer;"
                            onclick="document.getElementById('adminBannerFile').click()">
                            <i class="fa-solid fa-image"
                                style="font-size: 1.5rem; color: #cbd5e1; margin-bottom: 0.5rem; display:block;"></i>
                            <span style="font-size: 0.8rem; color: #64748b;">Click to upload</span>
                            <input type="file" hidden accept="image/*" id="adminBannerFile">
                        </div>
                    </div>
                </div>

                <div class="modal-footer"
                    style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem; border-top: 1px solid #f1f5f9; padding-top: 2rem;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('addWorkshopModal')"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: 2px solid #e2e8f0; background: white; color: #64748b; cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn btn-primary"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: none; cursor: pointer; display: flex; align-items: center; gap: 8px;"><i
                            class="fa-solid fa-plus-circle"></i> Create Workshop</button>
                </div>
            </form>
        </div>
    </div>



    <!-- Add Department Modal -->
    <div class="modal-overlay" id="addDeptModal">

        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <h3><i class="fa-solid fa-building"></i> Add Department</h3>
                <button class="modal-close" onclick="closeModal('addDeptModal')"><i
                        class="fa-solid fa-xmark"></i></button>
            </div>
            <form onsubmit="event.preventDefault(); saveDepartment();">
                <div class="input-group" style="margin-bottom: 1.5rem;">
                    <label>Department Name <span class="required" style="color:#ef4444">*</span></label>
                    <input type="text" id="newDeptName" required placeholder="e.g. Biomedical Engineering"
                        style="width:100%; padding:0.85rem; border:1.5px solid #e2e8f0; border-radius:8px; background:#f8fafc;" />
                </div>
                <div class="input-group" style="margin-bottom: 1.5rem;">
                    <label>Number of Years <span class="required" style="color:#ef4444">*</span></label>
                    <select id="newDeptYears" required
                        style="width:100%; padding:0.85rem; border:1.5px solid #e2e8f0; border-radius:8px; background:#f8fafc;">
                        <option value="4">4 Years</option>
                        <option value="5">5 Years</option>
                    </select>
                </div>
                <div class="modal-footer"
                    style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('addDeptModal')"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: 2px solid #e2e8f0; background: white; color: #64748b; cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn btn-primary"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: none; cursor: pointer;"><i
                            class="fa-solid fa-plus"></i> Add Department</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Toast Container -->
    <div class="toast-container" id="toastContainer"></div>

    <!-- ═══ ADD COURSE MODAL ═══ -->
    <div id="addCourseModal"
        style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
        <div
            style="background:white; border-radius:16px; padding:2rem; width:100%; max-width:480px; box-shadow:0 20px 60px rgba(0,0,0,0.2); position:relative;">
            <button onclick="closeAddCourseModal()"
                style="position:absolute; top:1rem; right:1rem; background:none; border:none; font-size:1.4rem; color:#64748b; cursor:pointer;">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <h3 style="color:var(--primary-dark); margin-bottom:1.5rem; font-size:1.2rem;">
                <i class="fa-solid fa-plus" style="color:var(--primary); margin-right:8px;"></i>Add New Course
            </h3>
            <form id="addCourseForm" onsubmit="submitAddCourse(event)">
                <div style="margin-bottom:1rem;">
                    <label
                        style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Course
                        Title <span style="color:red;">*</span></label>
                    <input type="text" id="ac_title" placeholder="e.g., Data Structures" required
                        style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; outline:none; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label
                        style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Course
                        Code <span style="color:red;">*</span></label>
                    <input type="text" id="ac_code" placeholder="e.g., CS201" required
                        style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; outline:none; box-sizing:border-box;">
                </div>
                <div style="margin-bottom:1rem;">
                    <label
                        style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Instructor</label>
                    <input type="text" id="ac_instructor" placeholder="e.g., Dr. Smith"
                        style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; outline:none; box-sizing:border-box;">
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem; margin-bottom:1rem;">
                    <div>
                        <label
                            style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Academic
                            Year <span style="color:red;">*</span></label>
                        <select id="ac_year" required
                            style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; outline:none;">
                            <option value="">Select Year</option>
                            <option value="1">Year 1</option>
                            <option value="2">Year 2</option>
                            <option value="3">Year 3</option>
                            <option value="4">Year 4</option>
                            <option value="5">Year 5</option>
                        </select>
                    </div>
                    <div>
                        <label
                            style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Semester
                            <span style="color:red;">*</span></label>
                        <select id="ac_semester" required
                            style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; outline:none;">
                            <option value="">Select Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                        </select>
                    </div>
                </div>
                <div style="margin-bottom:1.5rem;">
                    <label
                        style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Status</label>
                    <select id="ac_status"
                        style="width:100%; padding:0.6rem 0.8rem; border:1.5px solid #e2e8f0; border-radius:8px; font-size:0.9rem; outline:none;">
                        <option value="approved">Approved (visible to students)</option>
                        <option value="pending">Pending Review</option>
                    </select>
                </div>
                <div style="display:flex; gap:1rem; justify-content:flex-end;">
                    <button type="button" onclick="closeAddCourseModal()"
                        style="padding:0.6rem 1.4rem; border:1.5px solid #e2e8f0; border-radius:8px; background:white; color:#64748b; font-weight:600; cursor:pointer;">Cancel</button>
                    <button type="submit" class="btn" style="padding:0.6rem 1.4rem;" id="submitCourseBtn">
                        <i class="fa-solid fa-plus" style="margin-right:6px;"></i>Add Course
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const usersData = @json($users);
        const coursesData = @json($courses);
        const materialsData = @json($materials);
        const workshopsData = @json($workshops);
        const departmentsData = @json($departments);
        const commentsData = []; // Not implemented in DB yet
        const adminStats = @json($stats);
        const activityData = @json($activityData);

        // Add Course Modal
        function openAddCourseModal() {
            const modal = document.getElementById('addCourseModal');
            modal.style.display = 'flex';
        }

        function closeAddCourseModal() {
            const modal = document.getElementById('addCourseModal');
            modal.style.display = 'none';
            document.getElementById('addCourseForm').reset();
        }
        async function submitAddCourse(e) {
            e.preventDefault();
            const btn = document.getElementById('submitCourseBtn');
            btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin" style="margin-right:6px;"></i>Saving...';
            btn.disabled = true;

            const data = {
                title: document.getElementById('ac_title').value,
                code: document.getElementById('ac_code').value,
                instructor: document.getElementById('ac_instructor').value,
                year: document.getElementById('ac_year').value,
                semester: document.getElementById('ac_semester').value,
                status: document.getElementById('ac_status').value,
            };

            try {
                const res = await fetch('/admin/courses', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify(data)
                });
                const json = await res.json();
                if (json.success) {
                    // Push new course into the live array and re-render
                    coursesData.push(json.course);
                    renderCourses();
                    closeAddCourseModal();
                    showToast(`Course "${json.course.title}" added successfully!`, 'success');
                } else {
                    const errors = json.errors ? Object.values(json.errors).flat().join(' | ') :
                        'Failed to add course.';
                    showToast(errors, 'error');
                }
            } catch (err) {
                showToast('Network error. Please try again.', 'error');
            }

            btn.innerHTML = '<i class="fa-solid fa-plus" style="margin-right:6px;"></i>Add Course';
            btn.disabled = false;
        }
    </script>
    <script src="{{ asset('js/admin.js') }}"></script>
</body>

</html>
