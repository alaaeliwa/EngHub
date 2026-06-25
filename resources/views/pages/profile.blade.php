<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/profile.css') }}" />

    <title>{{ __('messages.prof_title') }} | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidbar')

        <main class="main-content">
            @include('components.topNav')

            <div style="padding: var(--space-2xl);">

                <!-- Profile Header -->
                <div class="profile-header-card">
                    <div class="profile-cover" style="background-image: url('{{ Auth::user()->cover_photo ? asset('storage/' . Auth::user()->cover_photo) : 'https://images.unsplash.com/photo-1517245386807-bb43f82c33c4?auto=format&fit=crop&q=80&w=2000' }}'); background-size: cover; background-position: center;" id="profile-cover-preview">
                        <button class="cover-upload-btn" onclick="document.getElementById('cover-upload').click()">
                            <i class="fa-solid fa-camera"></i> {{ __('messages.prof_change_cover') }}
                        </button>
                        <input type="file" id="cover-upload" name="cover_photo" form="profile-update-form" style="display: none;" accept="image/*" onchange="previewCoverImage(event)">
                    </div>

                    <div class="profile-info-section">
                        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                            <div class="profile-avatar-wrapper">
                                <img src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->first_name . ' ' . Auth::user()->last_name) . '&color=7F9CF5&background=EBF4FF' }}"
                                    alt="{{ Auth::user()->first_name }}" class="profile-avatar"
                                    id="profile-img-preview" />
                                <button class="avatar-upload-btn"
                                    onclick="document.getElementById('avatar-upload').click()">
                                    <i class="fa-solid fa-pen"></i>
                                </button>
                                <input type="file" id="avatar-upload" name="avatar" form="profile-update-form"
                                    style="display: none;" accept="image/*" onchange="previewImage(event)">
                            </div>
                            <button class="btn" style="margin-bottom: var(--space-md);"
                                onclick="toggleEditProfile()">
                                <i class="fa-solid fa-user-pen" style="margin-right: 8px;"></i> {{ __('messages.prof_edit') }}
                            </button>
                        </div>

                        <h1 class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                        <div class="profile-meta">
                            <div class="profile-meta-item">
                                <i class="fa-solid fa-graduation-cap" style="color: var(--primary);"></i>
                                <span>{{ Auth::user()->major ? __('messages.prof_' . str_replace(' ', '_', strtolower(Auth::user()->major))) : __('messages.prof_eng') }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <i class="fa-solid fa-calendar-days" style="color: var(--primary);"></i>
                                <span>{{ Auth::user()->academic_year ? __('messages.prof_year') . ' ' . preg_replace('/[^0-9]/', '', Auth::user()->academic_year) : __('messages.prof_yr_not_set') }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                <span>{{ __('messages.prof_faculty') }}</span>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div class="profile-edit-form" id="edit-profile-form">
                            <h3 style="margin-top:0; color: var(--primary-dark);">{{ __('messages.prof_edit_details') }}</h3>
                            <form method="POST" action="{{ route('profile.update') }}" id="profile-update-form"
                                enctype="multipart/form-data">
                                @csrf
                                <div
                                    style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md); margin-bottom: var(--space-md);">
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">First
                                            {{ __('messages.prof_fname') }}</label>
                                        <input type="text" name="first_name" value="{{ Auth::user()->first_name }}"
                                            required />
                                    </div>
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">Last
                                            {{ __('messages.prof_lname') }}</label>
                                        <input type="text" name="last_name" value="{{ Auth::user()->last_name }}"
                                            required />
                                    </div>
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">{{ __('messages.prof_major') }}</label>
                                        <select name="major">
                                            <option value="">{{ __('messages.prof_sel_major') }}</option>
                                            <option value="Software Engineering"
                                                {{ Auth::user()->major == 'Software Engineering' ? 'selected' : '' }}>
                                                {{ __('messages.prof_soft_eng') }}</option>
                                            <option value="Computer Engineering"
                                                {{ Auth::user()->major == 'Computer Engineering' ? 'selected' : '' }}>
                                                {{ __('messages.prof_comp_eng') }}</option>
                                            <option value="Civil Engineering"
                                                {{ Auth::user()->major == 'Civil Engineering' ? 'selected' : '' }}>
                                                {{ __('messages.prof_civil_eng') }}</option>
                                            <option value="Electrical Engineering"
                                                {{ Auth::user()->major == 'Electrical Engineering' ? 'selected' : '' }}>
                                                {{ __('messages.prof_elec_eng') }}</option>
                                        </select>
                                    </div>
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">{{ __('messages.up_lbl_year') }}</label>
                                        <select name="academic_year">
                                            <option value="">{{ __('messages.prof_sel_year') }}</option>
                                            <option value="Year 1"
                                                {{ Auth::user()->academic_year == 'Year 1' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 1
                                            </option>
                                            <option value="Year 2"
                                                {{ Auth::user()->academic_year == 'Year 2' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 2
                                            </option>
                                            <option value="Year 3"
                                                {{ Auth::user()->academic_year == 'Year 3' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 3
                                            </option>
                                            <option value="Year 4"
                                                {{ Auth::user()->academic_year == 'Year 4' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 4
                                            </option>
                                            <option value="Year 5"
                                                {{ Auth::user()->academic_year == 'Year 5' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 5
                                            </option>
                                        </select>
                                    </div>
                                    <div class="input-wrapper" style="grid-column: 1 / -1;">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">{{ __('messages.prof_bio_skills') }}</label>
                                        <textarea name="skills" rows="3" style="width: 100%; border: 1px solid var(--border-color); border-radius: var(--radius-md); padding: 10px; font-family: inherit;">{{ Auth::user()->skills }}</textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn">{{ __('messages.prof_save') }}</button>
                                <button type="button" class="btn btn-outline"
                                    onclick="toggleEditProfile()">{{ __('messages.cd_cancel') }}</button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Profile Grid Content -->
                <div class="profile-grid">

                    <!-- Left Column (Skills & About) -->
                    <div>
                        <div class="profile-card">
                            <div class="profile-card-header">
                                <h3 class="profile-card-title"><i class="fa-solid fa-bolt"
                                        style="color: #f59e0b;"></i> {{ __('messages.prof_skills_bio') }}</h3>
                            </div>
                            <div class="skills-container" id="skills-list" style="line-height: 1.6; color: var(--text-color);">
                                @if(Auth::user()->skills)
                                    @foreach(explode(',', Auth::user()->skills) as $skill)
                                        @if(trim($skill) !== '')
                                            <span class="skill-tag">{{ trim($skill) }}</span>
                                        @endif
                                    @endforeach
                                @else
                                    <p style="color: var(--text-muted); font-size: 0.9rem;">{{ __('messages.prof_no_skills') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Uploads & Certs) -->
                    <div>
                        <div class="profile-card">
                            <div class="profile-card-header">
                                <h3 class="profile-card-title"><i class="fa-solid fa-cloud-arrow-up"
                                        style="color: var(--primary);"></i> {{ __('messages.prof_my_uploads') }}</h3>
                            </div>

                            @forelse($materials as $material)
                            <div class="upload-item">
                                <div class="upload-icon" style="{{ $material->type == 'pdf' ? 'color: #ef4444; background: rgba(239, 68, 68, 0.1);' : 'color: #3b82f6; background: rgba(59, 130, 246, 0.1);' }}">
                                    <i class="fa-regular {{ $material->type == 'pdf' ? 'fa-file-pdf' : 'fa-file-code' }}"></i>
                                </div>
                                <div class="upload-details">
                                    <span class="upload-title">{{ $material->title }}</span>
                                    <span class="upload-meta">{{ $material->created_at->format('M d, Y') }} • {{ strtoupper($material->type) }} • <span style="color: {{ $material->status == 'approved' ? '#10b981' : ($material->status == 'rejected' ? '#ef4444' : '#f59e0b') }}; font-weight: 500;">{{ __('messages.' . 'dash_' . $material->status) }}</span></span>
                                </div>
                                <div class="upload-actions">
                                    <a href="{{ route('course.details', ['id' => $material->course_id]) }}" class="btn btn-outline"
                                        style="padding: 5px 10px; border-radius: var(--radius-sm);"><i
                                            class="fa-solid fa-eye"></i></a>
                                </div>
                            </div>
                            @empty
                            <div style="padding: 20px; text-align: center; color: var(--text-muted);">
                                <i class="fa-solid fa-folder-open" style="font-size: 2rem; color: #cbd5e1; margin-bottom: 10px; display: block;"></i>
                                {{ __('messages.prof_no_uploads') }}
                            </div>
                            @endforelse

                            <a href="{{ route('upload') }}" class="btn btn-outline"
                                style="width: 100%; margin-top: var(--space-md); border-style: dashed;"><i
                                    class="fa-solid fa-plus"></i> {{ __('messages.prof_upload_new') }}</a>
                        </div>
                    </div>

                </div>

            </div>

            <!-- Footer -->
            @include('components.footer')
        </main>
    </div>

    <script>
        function toggleEditProfile() {
            const form = document.getElementById('edit-profile-form');
            form.classList.toggle('active');
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-img-preview');
                output.src = reader.result;
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function previewCoverImage(event) {
            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('profile-cover-preview');
                output.style.backgroundImage = `url(${reader.result})`;
            }
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</body>

</html>
