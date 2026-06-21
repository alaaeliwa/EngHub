<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/course-details.css') }}" />

    <title>My Favorites | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidbar')

        <main class="main-content">
            @include('components.topNav')

            <div style="padding: var(--space-2xl);">
                <div class="page-header"
                    style="background: white; border-radius: var(--radius-lg); padding: var(--space-xl); border: 1px solid rgba(0,0,0,0.03); box-shadow: var(--shadow-sm); margin-bottom: var(--space-xl);">
                    <div class="header-content">
                        <h1 style="font-size: 2rem; color: var(--primary-dark); margin-bottom: var(--space-xs);">
                            <i class="fa-solid fa-heart" style="color: var(--primary); margin-right: 10px;"></i>My
                            Favorites
                        </h1>
                        <p style="color: var(--text-muted); font-size: 1rem;">View all your liked resources and
                            materials in one place.</p>
                    </div>
                </div>

                <div class="content-tabs-section" id="favorites-container">
                    <div class="tab-content" style="display: block;">
                        <div class="materials-table">
                            <div class="table-row header">
                                <div>FILE NAME</div>
                                <div>COURSE</div>
                                <div>DATE</div>
                                <div>ACTIONS</div>
                            </div>

                            @forelse($favorites as $material)
                                <div class="table-row favorite-item" data-id="{{ $material->id }}" id="fav-row-{{ $material->id }}">
                                    <div class="col-info">
                                        <div class="file-icon {{ strtolower($material->type) }}">
                                            @if(strtolower($material->type) == 'pdf')
                                                <i class="fa-regular fa-file-pdf"></i>
                                            @elseif(strtolower($material->type) == 'video')
                                                <i class="fa-solid fa-video"></i>
                                            @else
                                                <i class="fa-regular fa-file-lines"></i>
                                            @endif
                                        </div>
                                        <div class="file-details">
                                            <span class="file-name">{{ $material->title }}</span>
                                            <span class="file-size">{{ strtoupper($material->type) }}</span>
                                        </div>
                                    </div>
                                    <div class="col-meta">
                                        <span style="font-weight: 500; color: var(--primary-dark);">{{ $material->course ? $material->course->title : 'Unknown Course' }}</span>
                                    </div>
                                    <div class="col-date">{{ $material->created_at->format('M d, Y') }}</div>
                                    <div class="col-actions">
                                        <a href="{{ $material->file_path }}" class="btn btn-outline" target="_blank"
                                            style="padding: 6px 10px; border-radius: 50%; border-color: #cbd5e1; color: #64748b; text-decoration: none;"><i
                                                class="fa-regular fa-eye"></i></a>
                                        <a href="{{ $material->file_path }}" download class="btn btn-outline"
                                            style="padding: 6px 10px; border-radius: 50%; border-color: #cbd5e1; color: #64748b; text-decoration: none;"><i
                                                class="fa-solid fa-download"></i></a>
                                        <button class="btn btn-outline btn-unlike"
                                            style="padding: 6px 10px; border-radius: 50%; border-color: #cbd5e1; color: var(--primary);" 
                                            onclick="toggleFavorite({{ $material->id }}, this)"><i
                                                class="fa-solid fa-heart"></i></button>
                                    </div>
                                </div>
                            @empty
                                <div style="padding: 2rem; text-align: center; color: var(--text-muted);">
                                    <i class="fa-regular fa-heart" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 1rem;"></i>
                                    <p>You haven't added any materials to your favorites yet.</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Footer -->
            <<footer
                style="margin-top: auto; padding: var(--space-xl) var(--space-2xl); background: white; border-top: 1px solid rgba(0,0,0,0.05); display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: var(--space-md);">
                <div style="font-size: 0.9rem; color: var(--text-muted); font-weight: 500;">
                    &copy; 2026 <strong>EngHub</strong> Engineering Community. All rights reserved.
                </div>
                <div
                    style="display: flex; gap: var(--space-lg); font-size: 0.9rem; font-weight: 600; color: var(--text-secondary);">
                    <a href="#" style="transition: color 0.3s ease;">About</a>
                    <a href="#" style="transition: color 0.3s ease;">Privacy Policy</a>
                    <a href="#" style="transition: color 0.3s ease;">Terms of Service</a>
                    <a href="#" style="transition: color 0.3s ease;">Contact Us</a>
                </div>
                </footer>
        </main>
    </div>
</body>

</html>
