<header class="top-nav">
    <div class="top-nav-left" style="position: relative;">
        <div class="search-bar">
            <i class="fa-solid fa-magnifying-glass"></i>
            <input type="text" id="global-search" placeholder="Search resources, workshops, or notes..." autocomplete="off" />
        </div>
        <!-- Search Results Dropdown -->
        <div id="search-results-dropdown" style="display: none; position: absolute; top: 100%; left: 0; right: 0; background: white; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-top: 8px; z-index: 50; max-height: 400px; overflow-y: auto;">
            <div id="search-results-list" style="padding: 10px 0;"></div>
        </div>
    </div>
    <div class="top-nav-right" style="display: flex; gap: 10px; align-items: center;">
        <a href="{{ route('favorites') }}" class="btn notification-btn"
            style="border-radius: var(--radius-full); width: 42px; height: 42px; padding: 0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: inherit;">
            <i class="fa-solid fa-heart" style="color: var(--primary);"></i>
        </a>
        <div class="notification-wrapper" style="position: relative;">
            <button class="btn notification-btn" id="studentNotificationBtn"
                style="border-radius: var(--radius-full); width: 42px; height: 42px; padding: 0;">
                <i class="fa-regular fa-bell"></i>
                @if(auth()->check() && auth()->user()->unreadNotifications->count() > 0)
                    <span class="notification-badge" style="position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; padding: 2px 6px; font-size: 0.7rem;">{{ auth()->user()->unreadNotifications->count() }}</span>
                @endif
            </button>
            
            <div class="notification-dropdown" id="studentNotificationDropdown" style="display: none; position: absolute; top: 100%; right: 0; background: white; width: 300px; border: 1px solid #e2e8f0; border-radius: 8px; box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1); margin-top: 8px; z-index: 50;">
                <div class="dropdown-header" style="padding: 10px; border-bottom: 1px solid #e2e8f0;">
                    <h4 style="margin: 0; font-size: 1rem;">Notifications</h4>
                </div>
                <div class="dropdown-body" style="max-height: 300px; overflow-y: auto;">
                    @if(auth()->check() && auth()->user()->notifications->count() > 0)
                        @foreach(auth()->user()->unreadNotifications as $notification)
                            <div class="notification-item" style="padding: 10px; border-bottom: 1px solid #f1f5f9;">
                                <div style="font-size: 0.9rem; font-weight: 500;">{{ $notification->data['title'] ?? 'Notification' }}</div>
                                <div style="font-size: 0.8rem; color: #64748b;">{{ $notification->data['message'] ?? '' }}</div>
                                <div style="font-size: 0.7rem; color: #94a3b8; margin-top: 5px;">{{ $notification->created_at->diffForHumans() }}</div>
                            </div>
                        @endforeach
                    @else
                        <div style="padding: 10px; text-align: center; color: #64748b; font-size: 0.9rem;">No notifications</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('global-search');
        const searchDropdown = document.getElementById('search-results-dropdown');
        const searchList = document.getElementById('search-results-list');
        let timeout = null;

        searchInput.addEventListener('input', function(e) {
            clearTimeout(timeout);
            const query = e.target.value.trim();

            if (query.length < 2) {
                searchDropdown.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                fetch(`{{ route('search.api') }}?q=${encodeURIComponent(query)}`)
                    .then(response => response.json())
                    .then(data => {
                        searchList.innerHTML = '';
                        if (data.length === 0) {
                            searchList.innerHTML = '<div style="padding: 10px 15px; color: #64748b; font-size: 0.9rem;">No results found.</div>';
                        } else {
                            data.forEach(item => {
                                const link = document.createElement('a');
                                link.href = item.url;
                                link.style.cssText = 'display: block; padding: 10px 15px; text-decoration: none; color: #1e293b; border-bottom: 1px solid #f1f5f9; transition: background 0.2s;';
                                link.onmouseover = function() { this.style.backgroundColor = '#f8fafc'; };
                                link.onmouseout = function() { this.style.backgroundColor = 'transparent'; };
                                
                                link.innerHTML = `
                                    <div style="font-weight: 500; font-size: 0.95rem;">${item.title}</div>
                                    <div style="font-size: 0.8rem; color: #64748b; margin-top: 2px;">${item.type}</div>
                                `;
                                searchList.appendChild(link);
                            });
                        }
                        searchDropdown.style.display = 'block';
                    });
            }, 300);
        });

        // Hide dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !searchDropdown.contains(e.target)) {
                searchDropdown.style.display = 'none';
            }
        });

        // Student Notification Dropdown
        const studentNotificationBtn = document.getElementById('studentNotificationBtn');
        const studentNotificationDropdown = document.getElementById('studentNotificationDropdown');

        if (studentNotificationBtn && studentNotificationDropdown) {
            studentNotificationBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                if (studentNotificationDropdown.style.display === 'none') {
                    studentNotificationDropdown.style.display = 'block';
                } else {
                    studentNotificationDropdown.style.display = 'none';
                }
            });

            document.addEventListener('click', function(e) {
                if (!studentNotificationDropdown.contains(e.target) && e.target !== studentNotificationBtn) {
                    studentNotificationDropdown.style.display = 'none';
                }
            });

            studentNotificationDropdown.addEventListener('click', function(e) {
                e.stopPropagation();
            });
        }
    });

    // Global Favorite Toggle Function
    function toggleFavorite(materialId, btnElement) {
        fetch(`/favorite/${materialId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'added') {
                // Change to solid heart and active color
                btnElement.querySelector('i').classList.remove('fa-regular');
                btnElement.querySelector('i').classList.add('fa-solid');
                btnElement.style.color = 'var(--primary)';
                btnElement.style.borderColor = 'var(--primary)';
                if (typeof showToast !== 'undefined') showToast('Added to Favorites!', 'success');
            } else {
                // Change to regular heart and default color
                btnElement.querySelector('i').classList.remove('fa-solid');
                btnElement.querySelector('i').classList.add('fa-regular');
                btnElement.style.color = '#64748b';
                btnElement.style.borderColor = '#cbd5e1';
                
                // If we are on the favorites page, we might want to remove the row completely
                const row = document.getElementById(`fav-row-${materialId}`);
                if (row && window.location.pathname.includes('/favorites')) {
                    row.remove();
                }
                
                if (typeof showToast !== 'undefined') showToast('Removed from Favorites', 'info');
            }
        })
        .catch(error => console.error('Error toggling favorite:', error));
    }
</script>
