<!doctype html>
<html lang="{{ App::getLocale() }}" dir="{{ App::getLocale() == 'ar' ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="/favicon.ico" />
    <!-- fontawesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <!-- style -->
    <link rel="stylesheet" href="{{ asset('style/global.css') }}" />
    <link rel="stylesheet" href="{{ asset('style/register.css') }}" />

    <title>{{ __('messages.auth_register_title') }} | EngHub</title>
</head>

<body>
    <div style="position: absolute; top: 20px; {{ App::getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }} z-index: 10;">
        <a href="{{ route('lang.switch', App::getLocale() == 'ar' ? 'en' : 'ar') }}" class="btn btn-outline" style="border:none; background: rgba(255,255,255,0.8); backdrop-filter: blur(5px);">
            <i class="fa-solid fa-globe"></i> {{ App::getLocale() == 'ar' ? 'EN' : 'ع' }}
        </a>
    </div>
    <main class="register-page">
        <div class="register-container">
            <!-- Left Side: Media & Welcome -->
            <div class="register-media">
                <div class="media-content">
                    <a href="{{ route('home') }}" class="register-logo">
                        <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                    </a>
                    <div class="welcome-text">
                        <h1>{{ __('messages.auth_join_today') }}</h1>
                        <p>{{ __('messages.auth_join_today_sub') }}</p>
                    </div>
                    <div class="illustration-container">
                        <img src="{{ asset('hero.png') }}" alt="Illustration" />
                    </div>
                </div>
                <!-- Decorative elements -->
                <div class="media-shape-1"></div>
                <div class="media-shape-2"></div>
            </div>

            <!-- Right Side: Form -->
            <div class="register-form-area">
                <div class="form-wrapper">
                    <div class="form-header">
                        <a href="{{ route('home') }}" class="login-logo">
                            <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                        </a>
                        <h2>{{ __('messages.auth_create_account') }}</h2>
                        <p>{{ __('messages.auth_create_account_sub') }}</p>
                    </div>

                    <form class="register-form" method="POST" action="{{ route('register.post') }}">
                        @csrf
                        @if ($errors->any())
                            <div style="background: rgba(239, 68, 68, 0.1); color: #ef4444; padding: 10px; border-radius: 5px; margin-bottom: 15px; font-size: 0.9rem;">
                                <ul style="margin: 0; padding-left: 20px;">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="grid-2">
                            <div class="form-group">
                                <label for="first-name">{{ __('messages.auth_fname') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" id="first-name" name="first_name" value="{{ old('first_name') }}" placeholder="John" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last-name">{{ __('messages.auth_lname') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" id="last-name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('messages.auth_email') }}</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="major">{{ __('messages.auth_specialization') }}</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <select id="major" name="major" required onchange="if(this.value==='other') { document.getElementById('other-major-wrapper').style.display='block'; document.getElementById('other-major').required=true; } else { document.getElementById('other-major-wrapper').style.display='none'; document.getElementById('other-major').required=false; }">
                                    <option value="" disabled selected>{{ __('messages.auth_sel_field') }}</option>
                                    @if(isset($departments) && count($departments) > 0)
                                        @foreach($departments as $dept)
                                            <option value="{{ $dept->name }}">{{ $dept->name }}</option>
                                        @endforeach
                                    @else
                                        <option value="Software Engineering">Software Engineering</option>
                                        <option value="Civil Engineering">Civil Engineering</option>
                                    @endif
                                    <option value="other">{{ __('messages.auth_other') }}</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group" id="other-major-wrapper" style="display:none; margin-top: -10px; margin-bottom: 20px;">
                            <label for="other-major">{{ __('messages.auth_specify_major') }}</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-pen"></i>
                                <input type="text" id="other-major" name="other_major" placeholder="E.g. Mechatronics Engineering" />
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label for="academic_year">{{ __('messages.auth_acad_year') }} <span style="color:#ef4444">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-calendar-days"></i>
                                    <select id="academic_year" name="academic_year" required>
                                        <option value="" disabled selected>{{ __('messages.auth_sel_year') }}</option>
                                        <option value="1" {{ old('academic_year') == '1' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 1</option>
                                        <option value="2" {{ old('academic_year') == '2' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 2</option>
                                        <option value="3" {{ old('academic_year') == '3' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 3</option>
                                        <option value="4" {{ old('academic_year') == '4' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 4</option>
                                        <option value="5" {{ old('academic_year') == '5' ? 'selected' : '' }}>{{ __('messages.prof_year') }} 5</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="current_semester">{{ __('messages.auth_semester') }} <span style="color:#ef4444">*</span></label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-layer-group"></i>
                                    <select id="current_semester" name="current_semester" required>
                                        <option value="" disabled selected>{{ __('messages.auth_sel_semester') }}</option>
                                        <option value="1" {{ old('current_semester') == '1' ? 'selected' : '' }}>{{ __('messages.auth_sem_1') }}</option>
                                        <option value="2" {{ old('current_semester') == '2' ? 'selected' : '' }}>{{ __('messages.auth_sem_2') }}</option>
                                        <option value="summer" {{ old('current_semester') == 'summer' ? 'selected' : '' }}>{{ __('messages.auth_summer') }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label for="password">{{ __('messages.auth_password') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" id="password" name="password" placeholder="••••••••" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">{{ __('messages.auth_confirm_pass') }}</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" id="confirm-password" name="password_confirmation" placeholder="••••••••" required />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.auth_sign_up') }}</button>
                    </form>

                    <div class="form-footer">
                        <p>{{ __('messages.auth_have_account') }} <a href="{{ route('login') }}">{{ __('messages.auth_sign_in') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
