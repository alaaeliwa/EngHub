<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

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

    <title>{{ __('messages.wsc_add_new') }} | EngHub</title>
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
                        <h1>{{ __('messages.wsc_add_new') }}</h1>
                        <p>{{ __('messages.wsc_subtitle') }}</p>
                    </section>

                    <form id="createWorkshopForm" class="modern-workshop-form">
                        <!-- Card 1: Essential Info -->
                        <div class="form-card animate-in">
                            <div class="card-header">
                                <div class="card-icon"><i class="fa-solid fa-pen-to-square"></i></div>
                                <div class="card-title">
                                    <h3>{{ __('messages.wsc_essential_info') }}</h3>
                                    <p>{{ __('messages.wsc_core_details') }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <label for="workshopTitle">{{ __('messages.wsc_title') }} <span class="required">*</span></label>
                                    <input type="text" id="workshopTitle" placeholder="{{ __('messages.wsc_title_ph') }}"
                                        required>
                                </div>
                                <div class="input-group">
                                    <label for="workshopCategory">{{ __('messages.wsc_category') }} <span class="required">*</span></label>
                                    <select id="workshopCategory" required>
                                        <option value="">{{ __('messages.wsc_sel_category') }}</option>
                                        <option value="programming">{{ __('messages.ws_cat_prog') }}</option>
                                        <option value="soft-skills">{{ __('messages.ws_cat_soft') }}</option>
                                        <option value="design">{{ __('messages.ws_cat_design') }}</option>
                                        <option value="engineering">{{ __('messages.ws_cat_eng') }}</option>
                                    </select>
                                </div>
                                <div class="input-group full-width">
                                    <label for="workshopDescription">{{ __('messages.wsc_desc') }} <span class="required">*</span></label>
                                    <textarea id="workshopDescription" rows="4" placeholder="{{ __('messages.wsc_desc_ph') }}" required></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Card 2: Date & Logistics -->
                        <div class="form-card animate-in">
                            <div class="card-header">
                                <div class="card-icon"><i class="fa-solid fa-calendar-check"></i></div>
                                <div class="card-title">
                                    <h3>{{ __('messages.wsc_schedule') }}</h3>
                                    <p>{{ __('messages.wsc_when_where') }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="input-group">
                                        <label for="workshopDate">{{ __('messages.wsd_date') }} <span class="required">*</span></label>
                                        <input type="date" id="workshopDate" required>
                                    </div>
                                    <div class="input-group">
                                        <label for="workshopTime">{{ __('messages.wsc_start_time') }} <span class="required">*</span></label>
                                        <input type="time" id="workshopTime" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="input-group">
                                        <label for="workshopDuration">{{ __('messages.wsc_duration') }} <span
                                                class="required">*</span></label>
                                        <input type="number" id="workshopDuration" placeholder="e.g. 2" required>
                                    </div>
                                    <div class="input-group">
                                        <label for="workshopSeats">{{ __('messages.wsc_seats') }} <span
                                                class="required">*</span></label>
                                        <input type="number" id="workshopSeats" placeholder="e.g. 30" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="workshopType">{{ __('messages.wsc_type') }} <span class="required">*</span></label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" name="locationType" value="online" checked>
                                            <span>{{ __('messages.ws_type_online') }}</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="locationType" value="offline">
                                            <span>{{ __('messages.ws_type_offline') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group full-width" id="locationInputGroup">
                                    <label for="workshopLocation" id="locationLabel">{{ __('messages.wsc_link') }} <span
                                            class="required">*</span></label>
                                    <input type="text" id="workshopLocation"
                                        placeholder="{{ __('messages.wsc_link_ph') }}" required>
                                </div>
                                <div class="input-group full-width">
                                    <label style="display:block; font-weight:600; color:#374151; margin-bottom:4px; font-size:0.9rem;">{{ __('messages.wsc_departments') }}</label>
                                    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:0.5rem; max-height:120px; overflow-y:auto; border:1.5px solid #e2e8f0; border-radius:8px; padding:0.8rem;" id="workshopDepartments">
                                        @foreach($departments as $dept)
                                            <label style="display:flex; align-items:center; gap:0.5rem; font-size:0.85rem; color:#475569; cursor:pointer;">
                                                <input type="checkbox" value="{{ $dept->id }}" class="ws_department_checkbox">
                                                {{ $dept->name }}
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Card 3: Instructor & Media -->
                        <div class="form-card animate-in">
                            <div class="card-header">
                                <div class="card-icon"><i class="fa-solid fa-user-tie"></i></div>
                                <div class="card-title">
                                    <h3>{{ __('messages.wsc_instructor_media') }}</h3>
                                    <p>{{ __('messages.wsc_tell_who') }}</p>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group">
                                    <label for="instructorName">{{ __('messages.wsc_instructor_name') }} <span
                                            class="required">*</span></label>
                                    <input type="text" id="instructorName"
                                        placeholder="{{ __('messages.wsc_instructor_ph') }}" required>
                                </div>
                                <div class="input-group">
                                    <label>{{ __('messages.wsc_banner') }} <span class="required">*</span></label>
                                    <div class="upload-area" id="bannerUpload">
                                        <i class="fa-solid fa-image"></i>
                                        <p>{{ __('messages.wsc_click_upload') }}</p>
                                        <input type="file" hidden accept="image/*" id="bannerFile">
                                    </div>
                                </div>
                                <div class="input-group full-width">
                                    <label>{{ __('messages.wsc_add_resources') }}</label>
                                    <div class="resource-placeholders" style="display: flex; gap: 15px; flex-direction: column;">
                                        <div class="res-item" style="display: flex; align-items: center; gap: 10px; cursor: pointer;" id="pdfUpload">
                                            <i class="fa-solid fa-file-pdf"></i> <span id="pdfFileName">{{ __('messages.wsc_upload_pdf') }}</span>
                                            <input type="file" hidden accept=".pdf" id="pdfFile">
                                        </div>
                                        <div class="res-item" style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.5); padding: 10px; border-radius: 8px;">
                                            <i class="fa-solid fa-link"></i>
                                            <input type="text" id="usefulLinks" placeholder="{{ __('messages.wsc_paste_links') }}" style="border: none; background: transparent; outline: none; width: 100%; color: inherit; font-size: inherit; font-family: inherit;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Section -->
                        <div class="form-actions-bar animate-in">
                            <button type="button" class="btn btn-outline" onclick="history.back()">{{ __('messages.cd_cancel') }}</button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-plus-circle"></i> {{ __('messages.wsc_add_new') }}
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
