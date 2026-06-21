<!doctype html>
<html lang="en">

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

    <title>Reset Password | EngHub</title>
</head>

<body>
    <main class="forgot-password-page">
        <div class="forgot-container">
            <!-- Left Side: Media & Help -->
            <div class="forgot-media">
                <div class="media-content">
                    <a href="{{ route('home') }}" class="forgot-logo">
                        <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                    </a>
                    <div class="welcome-text">
                        <h1>Forgot Your Password?</h1>
                        <p>No worries! Enter your email address and we'll send you a link to reset your password and get
                            you back on track.</p>
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
                        <h2>Reset Password</h2>
                        <p>Enter the email associated with your account</p>
                    </div>

                    <form class="forgot-form">
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="email" placeholder="name@example.com" required />
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Send Reset Link</button>
                    </form>

                    <div class="form-footer">
                        <p>Remember your password? <a href="{{ route('login') }}">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
