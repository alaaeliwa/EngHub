<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/profile.css') }}" />

    <title>Student Profile | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidbar')

        <main class="main-content">
            @include('components.topNav')

            <div style="padding: var(--space-2xl);">

                <!-- Profile Header -->
                <div class="profile-header-card">
                    <div class="profile-cover">
                        <button class="cover-upload-btn" onclick="document.getElementById('cover-upload').click()">
                            <i class="fa-solid fa-camera"></i> Change Cover
                        </button>
                        <input type="file" id="cover-upload" style="display: none;" accept="image/*">
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
                                <i class="fa-solid fa-user-pen" style="margin-right: 8px;"></i> Edit Profile
                            </button>
                        </div>

                        <h1 class="profile-name">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</h1>
                        <div class="profile-meta">
                            <div class="profile-meta-item">
                                <i class="fa-solid fa-graduation-cap" style="color: var(--primary);"></i>
                                <span>{{ Auth::user()->major ?? 'Engineering' }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <i class="fa-solid fa-calendar-days" style="color: var(--primary);"></i>
                                <span>{{ Auth::user()->academic_year ?? 'Year Not Set' }}</span>
                            </div>
                            <div class="profile-meta-item">
                                <i class="fa-solid fa-location-dot" style="color: var(--primary);"></i>
                                <span>Engineering Faculty</span>
                            </div>
                        </div>

                        <!-- Edit Form -->
                        <div class="profile-edit-form" id="edit-profile-form">
                            <h3 style="margin-top:0; color: var(--primary-dark);">Edit Details</h3>
                            <form method="POST" action="{{ route('profile.update') }}" id="profile-update-form"
                                enctype="multipart/form-data">
                                @csrf
                                <div
                                    style="display: grid; grid-template-columns: 1fr 1fr; gap: var(--space-md); margin-bottom: var(--space-md);">
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">First
                                            Name</label>
                                        <input type="text" name="first_name" value="{{ Auth::user()->first_name }}"
                                            required />
                                    </div>
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">Last
                                            Name</label>
                                        <input type="text" name="last_name" value="{{ Auth::user()->last_name }}"
                                            required />
                                    </div>
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">Major</label>
                                        <select name="major">
                                            <option value="">Select Major...</option>
                                            <option value="Software Engineering"
                                                {{ Auth::user()->major == 'Software Engineering' ? 'selected' : '' }}>
                                                Software Engineering</option>
                                            <option value="Computer Engineering"
                                                {{ Auth::user()->major == 'Computer Engineering' ? 'selected' : '' }}>
                                                Computer Engineering</option>
                                            <option value="Civil Engineering"
                                                {{ Auth::user()->major == 'Civil Engineering' ? 'selected' : '' }}>
                                                Civil Engineering</option>
                                            <option value="Electrical Engineering"
                                                {{ Auth::user()->major == 'Electrical Engineering' ? 'selected' : '' }}>
                                                Electrical Engineering</option>
                                        </select>
                                    </div>
                                    <div class="input-wrapper">
                                        <label
                                            style="font-size: 0.85rem; color: var(--text-muted); margin-bottom: 5px; display: block;">Academic
                                            Year</label>
                                        <select name="academic_year">
                                            <option value="">Select Year...</option>
                                            <option value="Year 1"
                                                {{ Auth::user()->academic_year == 'Year 1' ? 'selected' : '' }}>Year 1
                                            </option>
                                            <option value="Year 2"
                                                {{ Auth::user()->academic_year == 'Year 2' ? 'selected' : '' }}>Year 2
                                            </option>
                                            <option value="Year 3"
                                                {{ Auth::user()->academic_year == 'Year 3' ? 'selected' : '' }}>Year 3
                                            </option>
                                            <option value="Year 4"
                                                {{ Auth::user()->academic_year == 'Year 4' ? 'selected' : '' }}>Year 4
                                            </option>
                                            <option value="Year 5"
                                                {{ Auth::user()->academic_year == 'Year 5' ? 'selected' : '' }}>Year 5
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn">Save Changes</button>
                                <button type="button" class="btn btn-outline"
                                    onclick="toggleEditProfile()">Cancel</button>
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
                                        style="color: #f59e0b;"></i> Skills</h3>
                                <button class="btn btn-outline" style="padding: 4px 8px; font-size: 0.8rem;"
                                    onclick="addSkillPrompt()"><i class="fa-solid fa-plus"></i></button>
                            </div>
                            <div class="skills-container" id="skills-list">
                                <span class="skill-tag">Java <i class="fa-solid fa-xmark remove-skill"
                                        onclick="this.parentElement.remove()"></i></span>
                                <span class="skill-tag">Python <i class="fa-solid fa-xmark remove-skill"
                                        onclick="this.parentElement.remove()"></i></span>
                                <span class="skill-tag">Web Development <i class="fa-solid fa-xmark remove-skill"
                                        onclick="this.parentElement.remove()"></i></span>
                                <span class="skill-tag">Data Structures <i class="fa-solid fa-xmark remove-skill"
                                        onclick="this.parentElement.remove()"></i></span>
                                <span class="skill-tag">UI/UX Design <i class="fa-solid fa-xmark remove-skill"
                                        onclick="this.parentElement.remove()"></i></span>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column (Uploads & Certs) -->
                    <div>
                        <div class="profile-card">
                            <div class="profile-card-header">
                                <h3 class="profile-card-title"><i class="fa-solid fa-cloud-arrow-up"
                                        style="color: var(--primary);"></i> My Uploads (Contributions)</h3>
                            </div>

                            <div class="upload-item">
                                <div class="upload-icon">
                                    <i class="fa-regular fa-file-pdf"></i>
                                </div>
                                <div class="upload-details">
                                    <span class="upload-title">Complete Midterm Summary - Data Structures</span>
                                    <span class="upload-meta">May 05, 2026 • 4.5 MB • 120 Downloads</span>
                                </div>
                                <div class="upload-actions">
                                    <button class="btn btn-outline"
                                        style="padding: 5px 10px; border-radius: var(--radius-sm);"><i
                                            class="fa-solid fa-pen"></i></button>
                                </div>
                            </div>

                            <div class="upload-item">
                                <div class="upload-icon" style="color: #10b981; background: rgba(16, 185, 129, 0.1);">
                                    <i class="fa-regular fa-file-code"></i>
                                </div>
                                <div class="upload-details">
                                    <span class="upload-title">Java OOP Final Project Source Code</span>
                                    <span class="upload-meta">April 20, 2026 • 2.1 MB • 85 Downloads</span>
                                </div>
                                <div class="upload-actions">
                                    <button class="btn btn-outline"
                                        style="padding: 5px 10px; border-radius: var(--radius-sm);"><i
                                            class="fa-solid fa-pen"></i></button>
                                </div>
                            </div>

                            <a href="{{ route('upload') }}" class="btn btn-outline"
                                style="width: 100%; margin-top: var(--space-md); border-style: dashed;"><i
                                    class="fa-solid fa-plus"></i> Upload New Material</a>
                        </div>

                        <div class="profile-card">
                            <div class="profile-card-header">
                                <h3 class="profile-card-title"><i class="fa-solid fa-certificate"
                                        style="color: #8b5cf6;"></i> Certifications & Courses</h3>
                                <button class="btn btn-outline" style="padding: 4px 8px; font-size: 0.8rem;"><i
                                        class="fa-solid fa-plus"></i></button>
                            </div>

                            <div class="cert-card">
                                <div class="cert-icon">
                                    <i class="fa-brands fa-aws"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div class="cert-title">AWS Certified Cloud Practitioner</div>
                                    <div class="cert-issuer">Amazon Web Services • Issued Jan 2026</div>
                                </div>
                            </div>

                            <div class="cert-card">
                                <div class="cert-icon"
                                    style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">
                                    <i class="fa-solid fa-code"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div class="cert-title">Advanced React and Next.js</div>
                                    <div class="cert-issuer">Coursera • Issued Nov 2025</div>
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

        function addSkillPrompt() {
            const skill = prompt("Enter a new skill:");
            if (skill && skill.trim() !== "") {
                const container = document.getElementById('skills-list');
                const span = document.createElement('span');
                span.className = 'skill-tag';
                span.innerHTML =
                    `${skill} <i class="fa-solid fa-xmark remove-skill" onclick="this.parentElement.remove()"></i>`;
                container.appendChild(span);
            }
        }
    </script>
</body>

</html>
