<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <!-- Favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="../images/favicon.ico" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- style -->
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/create-workshop.css') }}" />

    <title>Add New Workshop | EngHub</title>
</head>

<body>



    <div class="dashboard-layout">
        <!-- Sidebar -->
        @if(!request()->has('admin'))
            @include('components.sidbar')
        @endif

        <!-- Main Content Area -->
        <main class="main-content" @if(request()->has('admin')) style="margin-left: 0;" @endif>
            <!-- Top Navbar -->
            @if(!request()->has('admin'))
                @include('components.topNav')
            @endif
            <div class="content-body">
                <div class="form-wrapper">
                    <!-- Header Section -->
                    <section class="page-title-section animate-in">
                        <h1>Add New Workshop</h1>
                        <p>Create and organize an educational event for the EngHub community.</p>
                    </section>

                    <form id="createWorkshopForm" class="modern-workshop-form">
                        <!-- Card 1: Essential Info -->
                        <div class="form-card animate-in">
                            <div class="card-header">
                                <div class="card-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                                <div class="card-title">
                                    <h3>Essential Information</h3>
                                    <p>Core details about your workshop</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <label for="workshopTitle">Workshop Title <span class="required">*</span></label>
                                    <input type="text" id="workshopTitle" placeholder="Enter a catchy title..."
                                        required>
                                </div>
                                <div class="input-group">
                                    <label for="workshopCategory">Category <span class="required">*</span></label>
                                    <select id="workshopCategory" required>
                                        <option value="">Select Category</option>
                                        <option value="programming">Programming</option>
                                        <option value="soft-skills">Soft Skills</option>
                                        <option value="design">Design</option>
                                        <option value="engineering">Engineering Tools</option>
                                    </select>
                                </div>
                                <div class="input-group full-width">
                                    <label for="workshopDescription">Description <span class="required">*</span></label>
                                    <textarea id="workshopDescription" rows="4" placeholder="What will students learn? What are the goals?" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Date & Logistics -->
                        <div class="form-card animate-in">
                            <div class="card-header">
                                <div class="card-icon"><i class="fa-solid fa-calendar-check"></i></div>
                                <div class="card-title">
                                    <h3>Schedule & Logistics</h3>
                                    <p>When and where it will happen</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="input-group">
                                        <label for="workshopDate">Date <span class="required">*</span></label>
                                        <input type="date" id="workshopDate" required>
                                    </div>
                                    <div class="input-group">
                                        <label for="workshopTime">Start Time <span class="required">*</span></label>
                                        <input type="time" id="workshopTime" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="input-group">
                                        <label for="workshopDuration">Duration (Hours) <span
                                                class="required">*</span></label>
                                        <input type="number" id="workshopDuration" placeholder="e.g. 2" required>
                                    </div>
                                    <div class="input-group">
                                        <label for="workshopSeats">Available Seats <span
                                                class="required">*</span></label>
                                        <input type="number" id="workshopSeats" placeholder="e.g. 30" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="workshopType">Workshop Type <span class="required">*</span></label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" name="locationType" value="online" checked>
                                            <span>Online</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="locationType" value="offline">
                                            <span>Offline</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group full-width" id="locationInputGroup">
                                    <label for="workshopLocation" id="locationLabel">Meeting Link <span
                                            class="required">*</span></label>
                                    <input type="text" id="workshopLocation"
                                        placeholder="Enter Zoom, Meet link or Room number..." required>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Instructor & Media -->
                        <div class="form-card animate-in">
                            <div class="card-header">
                                <div class="card-icon"><i class="fa-solid fa-user-tie"></i></div>
                                <div class="card-title">
                                    <h3>Instructor & Media</h3>
                                    <p>Tell them who you are</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <label for="instructorName">Instructor Name <span
                                            class="required">*</span></label>
                                    <input type="text" id="instructorName"
                                        placeholder="Full name of the presenter..." required>
                                </div>
                                <div class="input-group">
                                    <label>Workshop Banner <span class="required">*</span></label>
                                    <div class="upload-area" id="bannerUpload">
                                        <i class="fa-solid fa-image"></i>
                                        <p>Click or drag to upload banner image</p>
                                        <input type="file" hidden accept="image/*" id="bannerFile">
                                    </div>
                                </div>
                                <div class="input-group full-width">
                                    <label>Additional Resources (Optional)</label>
                                    <div class="resource-placeholders" style="display: flex; gap: 15px; flex-direction: column;">
                                        <div class="res-item" style="display: flex; align-items: center; gap: 10px; cursor: pointer;" id="pdfUpload">
                                            <i class="fa-solid fa-file-pdf"></i> <span id="pdfFileName">Upload PDF Slides</span>
                                            <input type="file" hidden accept=".pdf" id="pdfFile">
                                        </div>
                                        <div class="res-item" style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.5); padding: 10px; border-radius: 8px;">
                                            <i class="fa-solid fa-link"></i>
                                            <input type="text" id="usefulLinks" placeholder="Paste useful links here..." style="border: none; background: transparent; outline: none; width: 100%; color: inherit; font-size: inherit; font-family: inherit;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Section -->
                        <div class="form-actions-bar animate-in">
                            <button type="button" class="btn btn-outline" onclick="history.back()">Cancel</button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-plus-circle"></i> Create Workshop
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if(!request()->has('admin'))
                @include('components.footer')
            @endif
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/create-workshop.js') }}"></script>
</body>

</html>
