<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <!-- Favicon -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="/favicon.ico" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">

    <!-- style -->
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/dashboard.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/create-workshop.css') }}" />

    <meta name="workshop-id" content="{{ $workshop->id }}">
    <title>{{ __('messages.wsc_edit') }} | EngHub</title>
</head>

<body>



    <div class="dashboard-layout">
        <!-- Sidebar -->
        @if (!request()->has('admin'))
            @include('components.sidbar')
        @endif

        <!-- Main Content Area -->
        <main class="main-content" @if (request()->has('admin')) style="margin-left: 0;" @endif>
            <!-- Top Navbar -->
            @if (!request()->has('admin'))
                @include('components.topNav')
            @endif
            <div class="content-body">
                <div class="form-wrapper">
                    <!-- Header Section -->
                    <section class="page-title-section animate-in">
                        <h1>{{ __('messages.wsc_edit') }}</h1>
                        <p>{{ __('messages.wsc_subtitle') }}</p>
                    </section>

                    <form id="editWorkshopForm" class="modern-workshop-form">
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
                                    <label for="workshopTitle">{{ __('messages.wsc_title') }} <span
                                            class="required">*</span></label>
                                    <input type="text" id="workshopTitle"
                                        placeholder="{{ __('messages.wsc_title_ph') }}" value="{{ $workshop->title }}"
                                        required>
                                </div>
                                <div class="input-group">
                                    <label for="workshopCategory">{{ __('messages.wsc_category') }} <span
                                            class="required">*</span></label>
                                    <select id="workshopCategory" required>
                                        <option value="">{{ __('messages.wsc_sel_category') }}</option>
                                        <option value="programming"
                                            {{ $workshop->category == 'programming' ? 'selected' : '' }}>
                                            {{ __('messages.ws_cat_prog') }}</option>
                                        <option value="soft-skills"
                                            {{ $workshop->category == 'soft-skills' ? 'selected' : '' }}>
                                            {{ __('messages.ws_cat_soft') }}</option>
                                        <option value="design" {{ $workshop->category == 'design' ? 'selected' : '' }}>
                                            {{ __('messages.ws_cat_design') }}</option>
                                        <option value="engineering"
                                            {{ $workshop->category == 'engineering' ? 'selected' : '' }}>
                                            {{ __('messages.ws_cat_eng') }}</option>
                                    </select>
                                </div>
                                <div class="input-group full-width">
                                    <label for="workshopDescription">{{ __('messages.wsc_desc') }} <span
                                            class="required">*</span></label>
                                    <textarea id="workshopDescription" rows="4" placeholder="{{ __('messages.wsc_desc_ph') }}" required>{{ $workshop->description }}</textarea>
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
                                        <label for="workshopDate">{{ __('messages.wsd_date') }} <span
                                                class="required">*</span></label>
                                        <input type="date" id="workshopDate"
                                            value="{{ \Carbon\Carbon::parse($workshop->date)->format('Y-m-d') }}"
                                            required>
                                    </div>
                                    <div class="input-group">
                                        <label for="workshopTime">{{ __('messages.wsc_start_time') }} <span
                                                class="required">*</span></label>
                                        <input type="time" id="workshopTime" value="{{ $workshop->time }}" required>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="input-group">
                                        <label for="workshopDuration">{{ __('messages.wsc_duration') }} <span
                                                class="required">*</span></label>
                                        <input type="number" id="workshopDuration" value="{{ $workshop->duration }}"
                                            placeholder="e.g. 2" required>
                                    </div>
                                    <div class="input-group">
                                        <label for="workshopSeats">{{ __('messages.wsc_seats') }} <span
                                                class="required">*</span></label>
                                        <input type="number" id="workshopSeats" value="{{ $workshop->capacity }}"
                                            placeholder="e.g. 30" required>
                                    </div>
                                </div>
                                <div class="input-group">
                                    <label for="workshopType">{{ __('messages.wsc_type') }} <span
                                            class="required">*</span></label>
                                    <div class="radio-group">
                                        <label class="radio-label">
                                            <input type="radio" name="locationType" value="online"
                                                {{ $workshop->type != 'offline' ? 'checked' : '' }}>
                                            <span>{{ __('messages.ws_type_online') }}</span>
                                        </label>
                                        <label class="radio-label">
                                            <input type="radio" name="locationType" value="offline"
                                                {{ $workshop->type == 'offline' ? 'checked' : '' }}>
                                            <span>{{ __('messages.ws_type_offline') }}</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="input-group full-width" id="locationInputGroup">
                                    <label for="workshopLocation" id="locationLabel">{{ __('messages.wsc_link') }}
                                        <span class="required">*</span></label>
                                    <input type="text" id="workshopLocation" value="{{ $workshop->location }}"
                                        placeholder="{{ __('messages.wsc_link_ph') }}" required>
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
                                        value="{{ $workshop->instructor_name }}"
                                        placeholder="{{ __('messages.wsc_instructor_ph') }}" required>
                                </div>
                                <div class="input-group">
                                    <label>{{ __('messages.wsc_banner') }} <span class="required">*</span></label>
                                    <div class="upload-area" id="bannerUpload" style="padding: 10px;">
                                        @if ($workshop->banner)
                                            <img src="{{ asset('storage/' . $workshop->banner) }}"
                                                style="max-width: 100%; max-height: 200px; border-radius: 8px; object-fit: cover;"
                                                alt="Banner Preview">
                                        @else
                                            <i class="fa-solid fa-image"></i>
                                            <p>{{ __('messages.wsc_click_upload') }}</p>
                                        @endif
                                        <input type="file" hidden accept="image/*" id="bannerFile">
                                    </div>
                                </div>
                                <div class="input-group full-width">
                                    <label>{{ __('messages.wsc_add_resources') }}</label>
                                    <div class="resource-placeholders"
                                        style="display: flex; gap: 15px; flex-direction: column;">
                                        <div class="res-item"
                                            style="display: flex; align-items: center; gap: 10px; cursor: pointer;"
                                            id="pdfUpload">
                                            <i class="fa-solid fa-file-pdf"></i> <span
                                                id="pdfFileName">{{ $workshop->pdf_slides ? basename($workshop->pdf_slides) : __('messages.wsc_upload_pdf') }}</span>
                                            <input type="file" hidden accept=".pdf" id="pdfFile">
                                        </div>
                                        <div class="res-item"
                                            style="display: flex; align-items: center; gap: 10px; background: rgba(255,255,255,0.5); padding: 10px; border-radius: 8px;">
                                            <i class="fa-solid fa-link"></i>
                                            <input type="text" id="usefulLinks"
                                                value="{{ $workshop->useful_links }}"
                                                placeholder="{{ __('messages.wsc_paste_links') }}"
                                                style="border: none; background: transparent; outline: none; width: 100%; color: inherit; font-size: inherit; font-family: inherit;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button Section -->
                        <div class="form-actions-bar animate-in">
                            <button type="button" class="btn btn-outline"
                                onclick="history.back()">{{ __('messages.cd_cancel') }}</button>
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="fa-solid fa-save"></i> {{ __('messages.wsc_save') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            @if (!request()->has('admin'))
                @include('components.footer')
            @endif
        </main>
    </div>

    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/edit-workshop.js') }}"></script>
</body>

</html>
