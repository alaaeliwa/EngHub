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
    <link rel="stylesheet" href="{{ asset('style/forgot-password.css') }}" />

    <title>{{ __('messages.auth_forgot_title') }} | EngHub</title>
</head>

<body>
    <div style="position: absolute; top: 20px; {{ App::getLocale() == 'ar' ? 'left: 20px;' : 'right: 20px;' }} z-index: 10;">
        <a href="{{ route('lang.switch', App::getLocale() == 'ar' ? 'en' : 'ar') }}" class="btn btn-outline" style="border:none; background: rgba(255,255,255,0.8); backdrop-filter: blur(5px);">
            <i class="fa-solid fa-globe"></i> {{ App::getLocale() == 'ar' ? 'EN' : 'ع' }}
        </a>
    </div>
    <main class="forgot-password-page">
        <div class="forgot-container">
            <!-- Left Side: Media & Help -->
            <div class="forgot-media">
                <div class="media-content">
                    <a href="{{ route('home') }}" class="forgot-logo">
                        <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                    </a>
                    <div class="welcome-text">
                        <h1>{{ __('messages.auth_forgot_h1') }}</h1>
                        <p>{{ __('messages.auth_forgot_h1_sub') }}</p>
                    </div>
                    <div class="illustration-container">
                        <img src="{{ asset('hero.png') }}" alt="Illustration" />
                    </div>
                </div>
                <!-- Decorative shapes -->
                <div class="media-shape-1"></div>
                <div class="media-shape-2"></div>
            </div>

            <!-- Right Side: Form -->
            <div class="forgot-form-area">
                <div class="form-wrapper">
                    <div class="form-header">
                        <a href="{{ route('home') }}" class="login-logo">
                            <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                        </a>
                        <h2>{{ __('messages.auth_forgot_h2') }}</h2>
                        <p>{{ __('messages.auth_forgot_h2_sub') }}</p>
                    </div>

                    @if (session('success'))
                        <div class="alert alert-success" style="margin-bottom: 20px; padding: 15px; background-color: #d1fae5; color: #065f46; border-radius: 8px; font-size: 0.9rem;">
                            {!! session('success') !!}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger" style="margin-bottom: 20px; padding: 15px; background-color: #fee2e2; color: #b91c1c; border-radius: 8px; font-size: 0.9rem;">
                            <ul style="margin: 0; padding-left: 20px;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form class="forgot-form" method="POST" action="{{ route('forgot-password.post') }}">
                        @csrf
                        <div class="form-group">
                            <label for="email">{{ __('messages.auth_email') }}</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="email" name="email" placeholder="name@example.com" required />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">{{ __('messages.auth_send_link') }}</button>
                    </form>

                    <div class="form-footer">
                        <p>{{ __('messages.auth_remember_pass') }} <a href="{{ route('login') }}">{{ __('messages.auth_sign_in') }}</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
