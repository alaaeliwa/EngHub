<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" href="/favicon.ico" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/upload-materials.css') }}" />

    <title>Upload Material | EngHub</title>
</head>

<body>
    <div class="dashboard-layout">
        @include('components.sidbar')

        <main class="main-content">
            @include('components.topNav')

            <div style="padding: var(--space-2xl); display: flex; flex-direction: column; align-items: center;">
                <div class="upload-container" style="width: 100%; max-width: 700px;">
                    <div class="upload-header" style="text-align: center; margin-bottom: 2rem;">
                        <h2
                            style="font-size: 1.5rem; color: var(--primary-dark); font-weight: 700; margin-bottom: 0.5rem;">
                            Upload Material</h2>
                        <p
                            style="color: var(--text-secondary); font-size: 0.95rem; max-width: 500px; margin: 0 auto; line-height: 1.5;">
                            Contribute to the engineering community by sharing high-quality academic resources. Please
                            ensure all uploads follow the academic integrity guidelines.
                        </p>
                    </div>

                    <div class="form-card" style="border: 1px solid #e2e8f0; box-shadow: none;">
                        <div class="card-body" style="padding: 2.5rem;">
                            <!-- Progress Steps -->
                            <div
                                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem; border-bottom: 2px solid #f1f5f9; padding-bottom: 0.5rem; position: relative;">
                                <div
                                    style="color: var(--primary); font-weight: 700; letter-spacing: 1px; font-size: 0.85rem; text-transform: uppercase;">
                                    SUBMISSION PROGRESS
                                </div>
                                <div style="color: var(--text-secondary); font-size: 0.85rem; font-weight: 600;">
                                    Step 1 of 1
                                </div>
                                <div
                                    style="position: absolute; bottom: -2px; left: 0; height: 2px; width: 50%; background-color: var(--primary);">
                                </div>
                            </div>

                            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem;">
                                <i class="fa-solid fa-circle-info" style="color: var(--primary);"></i>
                                <span style="font-weight: 600; color: var(--primary-dark); font-size: 0.95rem;">Resource
                                    Details</span>
                            </div>

                            <form action="{{ route('upload.success') }}" method="GET">
                                <div class="input-group" style="margin-bottom: 1.5rem;">
                                    <label>Title</label>
                                    <input type="text"
                                        placeholder="e.g., Finite Element Analysis Summary - Midterm Prep" />
                                </div>

                                <div class="input-group" style="margin-bottom: 1.5rem;">
                                    <label>Description</label>
                                    <textarea rows="4" placeholder="Briefly describe what this resource covers and how it helps students..."></textarea>
                                </div>

                                <div class="grid-2" style="margin-bottom: 1.5rem; gap: 1rem;">
                                    <div class="input-group">
                                        <label>Academic Year</label>
                                        <div style="display: flex; gap: 5px;" id="year-btns">
                                            @foreach([1,2,3,4,5] as $yr)
                                            <button type="button" class="year-btn"
                                                data-year="{{ $yr }}"
                                                style="flex: 1; padding: 0.6rem 0; background: white; border: 1px solid #cbd5e1; border-radius: var(--radius-sm); color: #64748b; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"
                                                onclick="selectYear(this, {{ $yr }})">Yr {{ $yr }}</button>
                                            @endforeach
                                        </div>
                                        <input type="hidden" name="year" id="year-value" value="">
                                    </div>
                                    <div class="input-group">
                                        <label>Semester</label>
                                        <div style="display: flex; gap: 5px;" id="sem-btns">
                                            <button type="button" class="sem-btn"
                                                data-sem="1"
                                                style="flex: 1; padding: 0.6rem 0; background: white; border: 1px solid #cbd5e1; border-radius: var(--radius-sm); color: #64748b; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"
                                                onclick="selectSem(this, 1)">Semester 1</button>
                                            <button type="button" class="sem-btn"
                                                data-sem="2"
                                                style="flex: 1; padding: 0.6rem 0; background: white; border: 1px solid #cbd5e1; border-radius: var(--radius-sm); color: #64748b; font-size: 0.85rem; cursor: pointer; transition: all 0.2s;"
                                                onclick="selectSem(this, 2)">Semester 2</button>
                                        </div>
                                        <input type="hidden" name="semester" id="sem-value" value="">
                                    </div>
                                </div>

                                <div class="grid-2" style="margin-bottom: 1.5rem; gap: 1rem;">
                                    <div class="input-group">
                                        <label>Course Selection</label>
                                        <select name="course_id" id="course-select" style="width:100%;">
                                            <option value="">— Select Year & Semester first —</option>
                                        </select>
                                        <small style="color: #64748b; font-size:0.8rem; margin-top:4px;">
                                            Choose the course this material belongs to.
                                        </small>
                                    </div>
                                    <div class="input-group">
                                        <label>File Type</label>
                                        <div style="position: relative;">
                                            <select style="width: 100%; appearance: none;">
                                                <option>PDF Document</option>
                                            </select>
                                            <i class="fa-solid fa-paperclip"
                                                style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); color: #64748b;"></i>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-group" style="margin-bottom: 1.5rem;">
                                    <label>Tags</label>
                                    <div
                                        style="display: flex; align-items: center; flex-wrap: wrap; gap: 5px; border: 1.5px solid #e2e8f0; border-radius: var(--radius-md); padding: 5px 10px; background-color: white;">
                                        <div
                                            style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; display: flex; align-items: center; gap: 5px; color: #475569;">
                                            Mechanics <i class="fa-solid fa-xmark"
                                                style="cursor: pointer; font-size: 0.75rem;"></i>
                                        </div>
                                        <div
                                            style="background: #f1f5f9; padding: 4px 8px; border-radius: 4px; font-size: 0.85rem; display: flex; align-items: center; gap: 5px; color: #475569;">
                                            Structural <i class="fa-solid fa-xmark"
                                                style="cursor: pointer; font-size: 0.75rem;"></i>
                                        </div>
                                        <input type="text" placeholder="Add keywords..."
                                            style="border: none; outline: none; background: transparent; padding: 5px; flex: 1; min-width: 100px; font-size: 0.9rem;" />
                                    </div>
                                    <small style="color: #64748b; font-size: 0.8rem; margin-top: 4px;">Press Enter to
                                        add tags. Use relevant technical terms for better searchability.</small>
                                </div>

                                <div class="input-group" style="margin-bottom: 2rem;">
                                    <label>File Upload</label>
                                    <div class="drop-zone" style="padding: 2.5rem 2rem;">
                                        <div
                                            style="width: 50px; height: 50px; background-color: #e0e7ff; border-radius: 12px; display: flex; justify-content: center; align-items: center; margin-bottom: 1rem;">
                                            <i class="fa-solid fa-file-arrow-up"
                                                style="color: #4f46e5; font-size: 1.5rem; margin: 0;"></i>
                                        </div>
                                        <p style="margin: 0; font-weight: 500;">Drag & Drop your files here</p>
                                        <small style="margin-bottom: 1rem; display: block;">Supports PDF, JPG, PNG, and
                                            ZIP files up to 50MB</small>
                                        <button type="button"
                                            style="background: white; border: 1px solid var(--primary); color: var(--primary); padding: 0.6rem 1.5rem; border-radius: var(--radius-sm); font-weight: 600; cursor: pointer;">Browse
                                            Files</button>
                                    </div>
                                </div>

                                <div
                                    style="border-top: 1px solid #f1f5f9; padding-top: 1.5rem; display: flex; justify-content: space-between; align-items: center;">
                                    <div style="display: flex; align-items: flex-start; gap: 10px; max-width: 250px;">
                                        <input type="checkbox" id="confirm"
                                            style="margin-top: 4px; width: 16px; height: 16px; cursor: pointer;" />
                                        <label for="confirm"
                                            style="font-size: 0.85rem; color: var(--text-secondary); line-height: 1.4; cursor: pointer;">
                                            I confirm this material respects all academic integrity rules.
                                        </label>
                                    </div>
                                    <div style="display: flex; gap: 15px; align-items: center;">
                                        <button type="button"
                                            style="background: transparent; border: none; color: #64748b; font-weight: 600; cursor: pointer;">Cancel</button>
                                        <button type="submit" class="btn"
                                            style="padding: 0.7rem 1.5rem; border-radius: var(--radius-sm);">Upload
                                            Resource</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            @include('components.footer')
        </main>
    </div>

    <script>
        // All courses injected from DB
        const allCourses = @json($courses);

        let selectedYear = null;
        let selectedSem = null;

        function selectYear(btn, year) {
            selectedYear = year;
            document.getElementById('year-value').value = year;
            document.querySelectorAll('.year-btn').forEach(b => {
                b.style.background = 'white';
                b.style.borderColor = '#cbd5e1';
                b.style.color = '#64748b';
                b.style.fontWeight = '400';
            });
            btn.style.background = '#eff6ff';
            btn.style.borderColor = '#3b82f6';
            btn.style.color = '#2563eb';
            btn.style.fontWeight = '700';
            updateCourseDropdown();
        }

        function selectSem(btn, sem) {
            selectedSem = sem;
            document.getElementById('sem-value').value = sem;
            document.querySelectorAll('.sem-btn').forEach(b => {
                b.style.background = 'white';
                b.style.borderColor = '#cbd5e1';
                b.style.color = '#64748b';
                b.style.fontWeight = '400';
            });
            btn.style.background = '#eff6ff';
            btn.style.borderColor = '#3b82f6';
            btn.style.color = '#2563eb';
            btn.style.fontWeight = '700';
            updateCourseDropdown();
        }

        function updateCourseDropdown() {
            const select = document.getElementById('course-select');
            select.innerHTML = '';

            if (!selectedYear || !selectedSem) {
                select.innerHTML = '<option value="">— Select Year & Semester first —</option>';
                return;
            }

            const filtered = allCourses.filter(c => c.year == selectedYear && c.semester == selectedSem);

            if (filtered.length === 0) {
                select.innerHTML = '<option value="">— No courses found for this selection —</option>';
            } else {
                select.innerHTML = '<option value="">— Select a Course —</option>';
                filtered.forEach(c => {
                    select.innerHTML += `<option value="${c.id}">${c.title} (${c.code})</option>`;
                });
            }
        }
    </script>
</body>

</html>
