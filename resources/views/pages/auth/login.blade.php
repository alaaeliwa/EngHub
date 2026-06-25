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
    <link rel="stylesheet" href="{{ asset('style/login.css') }}" />

    <title>{{ __('messages.auth_login_title') }} | EngHub</title>
</head>

<body>
    <div style="position: absolute; top: 20px; {{ App::getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }} z-index: 10;">
        <a href="{{ route('lang.switch', App::getLocale() == 'ar' ? 'en' : 'ar') }}" class="btn btn-outline" style="border:none; background: rgba(255,255,255,0.8); backdrop-filter: blur(5px);">
            <i class="fa-solid fa-globe"></i> {{ App::getLocale() == 'ar' ? 'EN' : 'ع' }}
        </a>
    </div>
    <main class="login-page">
        <div class="login-container">
            <!-- Left Side: Media & Welcome -->
            <div class="login-media">
                <div class="media-content">
                    <a href="{{ route('home') }}" class="login-logo-white">
                        <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                    </a>
                    <div class="welcome-text">
                        <h1>{{ __('messages.auth_welcome_back') }}</h1>
                        <p>{{ __('messages.auth_welcome_back_sub') }}</p>
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
            <div class="login-form-area">
                <div class="form-wrapper">
                    <div class="form-header">
                        <a href="{{ route('home') }}" class="login-logo">
                            <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                        </a>
                        <h2>{{ __('messages.auth_sign_in') }}</h2>
                        <p>{{ __('messages.auth_sign_in_sub') }}</p>
                    </div>

                    <form class="login-form" method="POST" action="{{ route('login.post') }}">
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
                        <div class="form-group">
                            <label for="email">{{ __('messages.auth_email') }}</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">{{ __('messages.auth_password') }}</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-lock"></i>
                                <input type="password" id="password" name="password" placeholder="••••••••" required />
                            </div>
                        </div>

                        <div class="form-options">
                            <label class="remember-me">
                                <input type="checkbox" />
                                <span>{{ __('messages.auth_remember') }}</span>
                            </label>
                            <a href="{{ route('forgot-password') }}" class="forgot-password">{{ __('messages.auth_forgot') }}</a>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.auth_sign_in') }}</button>
                    </form>

                    <div class="form-footer">
                        <p>{{ __('messages.auth_no_account') }} <a href="{{ route('register') }}">{{ __('messages.auth_sign_up') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
