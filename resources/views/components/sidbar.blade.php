        <aside class="sidebar">
            <div class="sidebar-header">
                <a href="{{ route('home') }}" class="sidebar-logo">
                    <img src="{{ asset('logo.png') }}" alt="EngHub Logo" />
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-group">
                    <a href="{{ route('dashboard') }}"
                        class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Dashboard</span>
                    </a>
                    <a href="{{ route('courses') }}"
                        class="nav-item {{ request()->routeIs('courses') ? 'active' : '' }}">
                        <i class="fa-solid fa-graduation-cap"></i>
                        <span>Courses</span>
                    </a>
                    <a href="{{ route('upload') }}" class="nav-item upload-nav">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                        <span>Uploads</span>
                    </a>
                    <a href="{{ route('workshops') }}" class="nav-item">
                        <i class="fa-solid fa-laptop-code"></i>
                        <span>Workshops</span>
                    </a>
                </div>
            </nav>

            <div class="sidebar-footer">
                <form method="POST" action="{{ route('logout') }}" style="margin: 0; padding: 0;">
                    @csrf
                    <button type="submit" class="btn btn-block"
                        style="width: 100%; gap: var(--space-sm); border-radius: var(--radius-md); background-color: rgba(239, 68, 68, 0.05); color: #ef4444; border: 1px solid rgba(239, 68, 68, 0.2); text-decoration: none; transition: all 0.2s ease; display: flex; align-items: center; justify-content: center; padding: 0.6rem 1rem; font-weight: 600; cursor: pointer;"
                        onmouseover="this.style.backgroundColor='#ef4444'; this.style.color='white';"
                        onmouseout="this.style.backgroundColor='rgba(239, 68, 68, 0.05)'; this.style.color='#ef4444';">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Logout</span>
                    </button>
                </form>
                @auth
                    <a href="{{ route('profile') }}" class="user-profile"
                        style="margin-top: var(--space-md); border-top: 1px solid rgba(0,0,0,0.03); padding-top: var(--space-sm); text-decoration: none; color: inherit; display: flex; align-items: center; gap: var(--space-sm); padding: var(--space-sm); border-radius: var(--radius-md); transition: background-color 0.2s;">
                        <div class="user-avatar">
                            <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&color=7F9CF5&background=EBF4FF' }}"
                                alt="{{ Auth::user()->first_name }}" />
                        </div>
                        <div class="user-info">
                            <span class="user-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</span>
                            <span class="user-role">{{ Auth::user()->academic_year ?? ucfirst(Auth::user()->role) }}</span>
                        </div>
                    </a>
                @endauth
            </div>
        </aside>
