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
    <link rel="stylesheet" href="{{ asset('style/register.css') }}" />

    <title>Sign Up | EngHub</title>
</head>

<body>
    <main class="register-page">
        <div class="register-container">
            <!-- Left Side: Media & Welcome -->
            <div class="register-media">
                <div class="media-content">
                    <a href="{{ route('home') }}" class="register-logo">
                        <img src="{{ asset('logo.png') }}" alt="EngHub logo" />
                    </a>
                    <div class="welcome-text">
                        <h1>Join EngHub Today!</h1>
                        <p>Create an account to learn new skills, build projects, and collaborate with engineers around
                            the globe.</p>
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
                        <h2>Create Account</h2>
                        <p>Start your engineering journey with us</p>
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
                                <label for="first-name">First Name</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" id="first-name" name="first_name" value="{{ old('first_name') }}" placeholder="John" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="last-name">Last Name</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" id="last-name" name="last_name" value="{{ old('last_name') }}" placeholder="Doe" required />
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-envelope"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com" required />
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="role">Role / Specialization</label>
                            <div class="input-wrapper">
                                <i class="fa-solid fa-graduation-cap"></i>
                                <select id="role" name="role" required>
                                    <option value="" disabled selected>Select your field</option>
                                    <option value="student">Engineering Student</option>
                                    <option value="software">Software Engineer</option>
                                    <option value="civil">Civil Engineer</option>
                                    <option value="electrical">Electrical Engineer</option>
                                    <option value="mechanical">Mechanical Engineer</option>
                                    <option value="other">Other Engineer</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid-2">
                            <div class="form-group">
                                <label for="password">Password</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" id="password" name="password" placeholder="••••••••" required />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Confirm Password</label>
                                <div class="input-wrapper">
                                    <i class="fa-solid fa-lock"></i>
                                    <input type="password" id="confirm-password" name="password_confirmation" placeholder="••••••••" required />
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                    </form>

                    <div class="form-footer">
                        <p>Already have an account? <a href="{{ route('login') }}">Sign In</a></p>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="{{ asset('js/auth.js') }}"></script>
</body>

</html>
