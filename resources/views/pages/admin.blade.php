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
                                    <span class="notification-badge" id="adminNotifBadge" style="display:none;">0</span>
                                </button>

                                <div class="notification-dropdown" id="notificationDropdown">
                                    <div class="dropdown-header">
                                        <h4>Notifications</h4>
                                        <span class="mark-read" id="markAllReadBtn" style="cursor:pointer;">Mark all as read</span>
                                    </div>
                                    <div class="dropdown-body" id="adminNotifList">
                                        <div style="padding:20px; text-align:center; color:#94a3b8;">
                                            <i class="fa-solid fa-spinner fa-spin"></i>
                                        </div>
                                    </div>
                                    <div class="dropdown-footer">
                                        <a href="#" onclick="document.querySelector('[data-tab=\'notifications\']').click(); return false;">View All Notifications</a>
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
                        <button class="admin-tab" data-tab="notifications" style="display:none;"><i class="fa-solid fa-bell"></i>
                            <span>Notifications</span></button>
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
                                    <th>Departments</th>
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
                                        <td>
                                            @forelse($c->departments as $d)
                                                <span class="badge" style="background:#f8fafc;color:#475569;border:1px solid #cbd5e1;margin-right:4px;display:inline-block;margin-bottom:2px;">{{ $d->name }}</span>
                                            @empty
                                                —
                                            @endforelse
                                        </td>
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
                                                    onclick="window.open('{{ route('material.view', $m->id) }}', '_blank')"><i
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
                                        <td><strong>{{ $c->user->first_name ?? '' }}
                                                {{ $c->user->last_name ?? '' }}</strong></td>
                                        <td style="max-width:300px; overflow:hidden; text-overflow:ellipsis; white-space:nowrap;"
                                            title="{{ $c->body }}">
                                            {{ $c->body }}
                                        </td>
                                        <td>{{ $c->course->title ?? 'N/A' }}</td>
                                        <td>{{ $c->created_at->format('M d, Y') }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="action-btn delete" title="Delete Comment"
                                                    onclick="deleteCommentDB({{ $c->id }}, this)"><i
                                                        class="fa-solid fa-trash"></i></button>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" style="text-align:center; color:#64748b;">No comments
                                            found.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- ═══ DEPARTMENTS TAB ═══ -->
                <div class="tab-panel" id="panel-departments">
                    <div class="panel-header">
                        <h2>Departments & Workshops</h2>
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
                                    <th>Workshops</th>
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
                                        <td>{{ $d->workshops }}</td>
                                        <td>
                                            <div class="action-btns">
                                                <button class="action-btn edit" title="Edit" onclick="editDepartment({{ $d->id }}, '{{ addslashes($d->name) }}', {{ $d->years }})"><i
                                                        class="fa-solid fa-pen"></i></button>
                                                <button class="action-btn delete" title="Delete" onclick="deleteDepartment({{ $d->id }})"><i
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

                <!-- ── Notifications Tab Panel ── -->
                <div id="panel-notifications" class="tab-panel">
                    <div class="panel-header">
                        <h2>Admin Notifications</h2>
                        <div class="panel-actions">
                            <button class="btn-mark-all" onclick="fetch('{{ route('notifications.read-all') }}', {method: 'POST', headers: {'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').content, 'Accept': 'application/json'}}).then(r=>r.json()).then(d=>{if(d.success){document.querySelectorAll('#panel-notifications .an-card.unread').forEach(el=>el.classList.remove('unread'));}});" style="background: rgba(0, 98, 87, 0.08); color: #006257; border: 1px solid rgba(0, 98, 87, 0.2); padding: 8px 16px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px;" onmouseover="this.style.background='rgba(0, 98, 87, 0.15)'" onmouseout="this.style.background='rgba(0, 98, 87, 0.08)'">
                                <i class="fa-solid fa-check-double"></i> Mark All as Read
                            </button>
                        </div>
                    </div>

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
                            'color'       => '#006257',
                            'bg'          => 'rgba(0,98,87,0.12)',
                            'icon'        => 'fa-bell',
                            'label'       => 'General',
                            'label_bg'    => '#e0f2f1',
                            'label_color' => '#004d40',
                        ];
                    @endphp

                    <div style="background:white; border-radius:var(--radius-lg); border:1px solid var(--border-color); padding:24px;">
                        <div style="display:flex; flex-direction:column; gap:12px;">
                            @if(isset($notifications) && $notifications->count() > 0)
                                @foreach($notifications as $notification)
                                    @php
                                        $data   = $notification->data ?? [];
                                        $type   = $data['type']    ?? 'general';
                                        $cfg    = $typeConfig[$type] ?? $defaultConfig;
                                        $unread = is_null($notification->read_at);
                                        $actionUrl = route('notifications.read', $notification->id);
                                    @endphp
                                    <a href="{{ $actionUrl }}" class="an-card {{ $unread ? 'unread' : '' }}" style="display:flex; align-items:flex-start; gap:16px; padding:16px; border:1px solid {{ $unread ? 'var(--primary)' : 'var(--border-color)' }}; border-radius:12px; text-decoration:none; color:var(--text-color); background:{{ $unread ? 'rgba(0,98,87,0.03)' : '#fff' }}; transition:all 0.2s;">
                                        <div style="width:48px; height:48px; border-radius:10px; display:flex; align-items:center; justify-content:center; flex-shrink:0; background:{{ $cfg['bg'] }}; color:{{ $cfg['color'] }}; font-size:1.2rem;">
                                            <i class="fa-solid {{ $cfg['icon'] }}"></i>
                                        </div>
                                        <div style="flex:1;">
                                            <div style="font-weight:700; font-size:0.95rem; margin-bottom:4px; color:var(--text-color);">{{ $data['title'] ?? 'Notification' }}</div>
                                            <div style="font-size:0.85rem; color:var(--text-secondary); margin-bottom:8px; line-height:1.5;">{{ $data['message'] ?? '' }}</div>
                                            <div style="display:flex; align-items:center; gap:12px;">
                                                <span style="font-size:0.75rem; color:#94a3b8;"><i class="fa-regular fa-clock" style="margin-right:4px;"></i>{{ $notification->created_at->diffForHumans() }}</span>
                                                <span style="font-size:0.7rem; font-weight:600; padding:2px 8px; border-radius:999px; background:{{ $cfg['label_bg'] }}; color:{{ $cfg['label_color'] }};">{{ $cfg['label'] }}</span>
                                            </div>
                                        </div>
                                        @if($unread)
                                            <div style="width:10px; height:10px; background:var(--primary); border-radius:50%; margin-top:8px;"></div>
                                        @endif
                                    </a>
                                @endforeach
                            @else
                                <div style="text-align:center; padding:48px; color:#94a3b8;">
                                    <i class="fa-solid fa-bell-slash" style="font-size:3rem; margin-bottom:16px; color:#cbd5e1;"></i>
                                    <h3 style="color:#64748b; margin-bottom:8px;">No notifications</h3>
                                    <p style="font-size:0.9rem;">You're all caught up!</p>
                                </div>
                            @endif
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
                    <select name="department_id" required>
                        <option value="">Select Department</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}">{{ $dept->name }}</option>
                        @endforeach
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

    <!-- Edit Department Modal -->
    <div class="modal-overlay" id="editDeptModal">
        <div class="modal" style="max-width: 500px;">
            <div class="modal-header">
                <h3><i class="fa-solid fa-pen"></i> Edit Department</h3>
                <button class="modal-close" onclick="closeModal('editDeptModal')"><i class="fa-solid fa-xmark"></i></button>
            </div>
            <form onsubmit="event.preventDefault(); submitEditDepartment();">
                <input type="hidden" id="editDeptId" />
                <div class="input-group" style="margin-bottom: 1.5rem;">
                    <label>Department Name <span class="required" style="color:#ef4444">*</span></label>
                    <input type="text" id="editDeptName" required placeholder="e.g. Biomedical Engineering"
                        style="width:100%; padding:0.85rem; border:1.5px solid #e2e8f0; border-radius:8px; background:#f8fafc;" />
                </div>
                <div class="input-group" style="margin-bottom: 1.5rem;">
                    <label>Number of Years <span class="required" style="color:#ef4444">*</span></label>
                    <select id="editDeptYears" required
                        style="width:100%; padding:0.85rem; border:1.5px solid #e2e8f0; border-radius:8px; background:#f8fafc;">
                        <option value="4">4 Years</option>
                        <option value="5">5 Years</option>
                    </select>
                </div>
                <div class="modal-footer"
                    style="display: flex; justify-content: flex-end; gap: 1rem; margin-top: 2rem;">
                    <button type="button" class="btn btn-outline" onclick="closeModal('editDeptModal')"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: 2px solid #e2e8f0; background: white; color: #64748b; cursor: pointer;">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitEditDeptBtn"
                        style="padding: 0.8rem 1.5rem; border-radius: var(--radius-md); font-weight: 700; border: none; cursor: pointer;"><i
                            class="fa-solid fa-save"></i> Save Changes</button>
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
                <div style="margin-bottom:1rem;">
                    <label
                        style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">Departments</label>
                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:0.5rem; max-height:100px; overflow-y:auto; border:1.5px solid #e2e8f0; border-radius:8px; padding:0.8rem;"
                        id="ac_departments">
                        @foreach ($departments as $dept)
                            <label
                                style="display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#475569; cursor:pointer;">
                                <input type="checkbox" value="{{ $dept->id }}" class="ac_department_checkbox">
                                {{ $dept->name }}
                            </label>
                        @endforeach
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

            const selectedDepts = Array.from(document.querySelectorAll('.ac_department_checkbox:checked')).map(cb => cb
                .value);

            const data = {
                title: document.getElementById('ac_title').value,
                code: document.getElementById('ac_code').value,
                instructor: document.getElementById('ac_instructor').value,
                year: document.getElementById('ac_year').value,
                semester: document.getElementById('ac_semester').value,
                status: document.getElementById('ac_status').value,
                departments: selectedDepts,
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

    {{-- ─── Admin Real Notifications Script ─── --}}
    <script>
    (function () {
        const NOTIF_API   = '{{ route("admin.notifications.json") }}';
        const CSRF        = '{{ csrf_token() }}';
        const badge       = document.getElementById('adminNotifBadge');
        const list        = document.getElementById('adminNotifList');
        const markAllBtn  = document.getElementById('markAllReadBtn');
        const btn         = document.getElementById('notificationBtn');
        const dropdown    = document.getElementById('notificationDropdown');

        // ── Icon colours per type ──
        const typeMap = {
            material_uploaded : { color: '#3b82f6', bg: 'rgba(59,130,246,0.1)' },
            comment_reported  : { color: '#ef4444', bg: 'rgba(239,68,68,0.1)'  },
            workshop_created  : { color: '#f59e0b', bg: 'rgba(245,158,11,0.1)' },
        };

        function renderNotif(n) {
            const style = typeMap[n.type] || { color: n.color, bg: n.bg_color };
            const unreadClass = n.is_unread ? 'unread' : '';
            return `
            <a href="${n.read_url}" class="notification-item ${unreadClass}" style="text-decoration:none;display:flex;align-items:flex-start;gap:10px;padding:12px 16px;border-bottom:1px solid #f1f5f9;transition:background .15s;" onmouseover="this.style.background='#f8fafc'" onmouseout="this.style.background='transparent'">
                <div class="notif-icon" style="background:${style.bg};color:${style.color};flex-shrink:0;width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;">
                    <i class="fa-solid ${n.icon}"></i>
                </div>
                <div class="notif-content" style="flex:1;min-width:0;">
                    <p style="margin:0 0 2px;font-size:.85rem;font-weight:600;color:#1e293b;line-height:1.3;">${n.title}</p>
                    <p style="margin:0 0 4px;font-size:.78rem;color:#64748b;line-height:1.4;white-space:normal;">${n.message}</p>
                    <span class="notif-time" style="font-size:.72rem;color:#94a3b8;">${n.time}</span>
                </div>
                ${n.is_unread ? '<span style="width:8px;height:8px;background:#6366f1;border-radius:50%;flex-shrink:0;margin-top:4px;"></span>' : ''}
            </a>`;
        }

        async function loadNotifications() {
            try {
                const res  = await fetch(NOTIF_API, { headers: { 'Accept': 'application/json' } });
                const data = await res.json();

                // Update badge
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    badge.style.display = '';
                } else {
                    badge.style.display = 'none';
                }

                // Render notifications
                if (data.notifications.length === 0) {
                    list.innerHTML = '<div style="padding:24px;text-align:center;color:#94a3b8;font-size:.85rem;"><i class="fa-solid fa-bell-slash" style="font-size:1.5rem;display:block;margin-bottom:8px;"></i>No notifications</div>';
                } else {
                    list.innerHTML = data.notifications.map(renderNotif).join('');
                }
            } catch (e) {
                list.innerHTML = '<div style="padding:16px;text-align:center;color:#ef4444;font-size:.83rem;">Failed to load notifications</div>';
            }
        }

        // Toggle dropdown
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const isOpen = dropdown.style.display === 'block';
            dropdown.style.display = isOpen ? 'none' : 'block';
            if (!isOpen) loadNotifications();
        });

        document.addEventListener('click', function (e) {
            if (!dropdown.contains(e.target) && e.target !== btn) {
                dropdown.style.display = 'none';
            }
        });

        // Mark all as read
        markAllBtn.addEventListener('click', async function () {
            await fetch('{{ route("notifications.read-all") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' }
            });
            badge.style.display = 'none';
            // Re-render without unread dots
            document.querySelectorAll('#adminNotifList .notification-item').forEach(el => {
                el.classList.remove('unread');
                const dot = el.querySelector('span[style*="border-radius:50%"]');
                if (dot) dot.remove();
            });
        });

        // Auto-refresh badge every 60s
        setInterval(async () => {
            try {
                const res  = await fetch(NOTIF_API, { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    badge.style.display = '';
                } else {
                    badge.style.display = 'none';
                }
            } catch (_) {}
        }, 60000);

        // Initial badge load
        (async () => {
            try {
                const res  = await fetch(NOTIF_API, { headers: { 'Accept': 'application/json' } });
                const data = await res.json();
                if (data.unread_count > 0) {
                    badge.textContent = data.unread_count > 99 ? '99+' : data.unread_count;
                    badge.style.display = '';
                }
            } catch (_) {}
        })();

        // Open correct tab when clicking a notification link containing #tab
        document.addEventListener('click', function (e) {
            const link = e.target.closest('a[href*="#"]');
            if (!link) return;
            const hash = link.getAttribute('href').split('#')[1];
            if (!hash) return;
            const targetTab = document.querySelector(`[data-tab="${hash}"]`);
            if (targetTab) {
                e.preventDefault();
                targetTab.click();
                window.scrollTo({ top: 0, behavior: 'smooth' });
                dropdown.style.display = 'none';
            }
        });

        // Check hash on page load to switch tabs correctly if coming from a redirect
        if (window.location.hash) {
            const hash = window.location.hash.substring(1);
            const targetTab = document.querySelector(`[data-tab="${hash}"]`);
            if (targetTab) {
                targetTab.click();
            }
        }
    })();
    </script>
</body>

</html>
