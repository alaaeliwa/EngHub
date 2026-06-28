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
    <link rel="stylesheet" href="{{ asset('style/style.css') }}" />

    <title>EngHub</title>
</head>

<body>
    <nav class="nav">
        <div class="container nav-wrapper">
            <a href="{{ route('home') }}" class="nav-logo">
                <img src="/logo.png" alt="EngHub logo" />
            </a>

            <div class="nav-menu" id="navMenu">
                <ul class="nav-links">
                    <li><a href="{{ route('home') }}" class="nav-link">{{ __('messages.nav_home') }}</a></li>
                    <li><a href="#Features" class="nav-link">{{ __('messages.nav_features') }}</a></li>
                    <li><a href="#How-it-works" class="nav-link">{{ __('messages.nav_how_it_works') }}</a></li>
                    <li><a href="#About" class="nav-link">{{ __('messages.nav_about') }}</a></li>
                </ul>
                <div class="nav-buttons">
                    <a href="{{ route('lang.switch', App::getLocale() == 'ar' ? 'en' : 'ar') }}" class="btn btn-outline" style="border:none;">
                        <i class="fa-solid fa-globe"></i> {{ App::getLocale() == 'ar' ? 'English' : 'العربية' }}
                    </a>
                    <a href="{{ route('login') }}" class="btn btn-outline">{{ __('messages.nav_login') }}</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">{{ __('messages.nav_get_started') }}</a>
                </div>
            </div>

            <button class="nav-toggle" id="navToggle" aria-label="Toggle navigation">
                <span></span>
                <span></span>
                <span></span>
            </button>
        </div>
    </nav>
    <header class="hero">
        <div class="container">
            <div class="hero-wrapper">
                <div class="hero-text">
                    <div class="hero-badge">{{ __('messages.hero_badge') }}</div>
                    <h1 class="hero-title">
                        <span class="cursive-text">{{ __('messages.hero_title_1') }}</span> {{ __('messages.hero_title_2') }}
                    </h1>
                    <p class="hero-subtitle">
                        {{ __('messages.hero_subtitle') }}
                    </p>
                    <div class="hero-actions">
                        <a href="#courses" class="btn btn-primary">{{ __('messages.hero_btn_start') }}</a>
                        <a href="#about" class="btn btn-outline">{{ __('messages.hero_btn_about') }}</a>
                    </div>
                </div>

                <div class="hero-media">
                    <div class="illustration-box">
                        <img src="/hero.png" alt="Engineering Illustration" />
                        <!-- Floating Stats Card -->
                        <div class="floating-card">
                            <div class="card-icon"><i class="fa-solid fa-users"></i></div>
                            <div class="card-info">
                                <strong>5,000+</strong>
                                <span>{{ __('messages.hero_stats_active') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <section id="Features" class="features section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">{{ __('messages.feat_badge') }}</span>
                <h2 class="section-title">{{ __('messages.feat_title_1') }} <span class="text-primary">{{ __('messages.feat_title_2') }}</span></h2>
                <p class="section-subtitle">{{ __('messages.feat_subtitle') }}</p>
            </div>

            <div class="grid grid-cols-4 feature-grid">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-1">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="feature-title">{{ __('messages.feat_1_title') }}</h3>
                    <p class="feature-description">{{ __('messages.feat_1_desc') }}</p>
                    <div class="feature-hover-indicator"></div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-2">
                        <i class="fa-solid fa-hands-helping"></i>
                    </div>
                    <h3 class="feature-title">{{ __('messages.feat_2_title') }}</h3>
                    <p class="feature-description">{{ __('messages.feat_2_desc') }}</p>
                    <div class="feature-hover-indicator"></div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-3">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h3 class="feature-title">{{ __('messages.feat_3_title') }}</h3>
                    <p class="feature-description">{{ __('messages.feat_3_desc') }}</p>
                    <div class="feature-hover-indicator"></div>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-4">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="feature-title">{{ __('messages.feat_4_title') }}</h3>
                    <p class="feature-description">{{ __('messages.feat_4_desc') }}</p>
                    <div class="feature-hover-indicator"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="How-it-works" class="how-it-works section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">{{ __('messages.how_badge') }}</span>
                <h2 class="section-title">{{ __('messages.how_title_1') }} <span class="text-primary">{{ __('messages.how_title_2') }}</span></h2>
                <p class="section-subtitle">{{ __('messages.how_subtitle') }}</p>
            </div>

            <div class="steps-container">
                <div class="steps-row">
                    <!-- Step 1 -->
                    <div class="step-item">
                        <div class="step-number">01</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>
                            <h3 class="step-title">{{ __('messages.how_step_1_title') }}</h3>
                            <p class="step-description">{{ __('messages.how_step_1_desc') }}</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step-item">
                        <div class="step-number">02</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <h3 class="step-title">{{ __('messages.how_step_2_title') }}</h3>
                            <p class="step-description">{{ __('messages.how_step_2_desc') }}</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step-item">
                        <div class="step-number">03</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <h3 class="step-title">{{ __('messages.how_step_3_title') }}</h3>
                            <p class="step-description">{{ __('messages.how_step_3_desc') }}</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="step-item">
                        <div class="step-number">04</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <h3 class="step-title">{{ __('messages.how_step_4_title') }}</h3>
                            <p class="step-description">{{ __('messages.how_step_4_desc') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="About" class="about section">
        <div class="container">
            <div class="about-wrapper">
                <div class="about-content">
                    <span class="section-badge">{{ __('messages.about_badge') }}</span>
                    <h2 class="section-title">{{ __('messages.about_title_1') }} <span
                            class="text-primary">{{ __('messages.about_title_2') }}</span></h2>

                    <p class="about-text">
                        <strong>EngHub</strong> {{ __('messages.about_text_1') }}
                    </p>

                    <div class="about-features">
                        <div class="about-feature-item">
                            <div class="about-feature-icon"><i class="fa-solid fa-users-gear"></i></div>
                            <div class="about-feature-text">
                                <h4>{{ __('messages.about_feat_1_title') }}</h4>
                                <p>{{ __('messages.about_feat_1_desc') }}</p>
                            </div>
                        </div>

                        <div class="about-feature-item">
                            <div class="about-feature-icon"><i class="fa-solid fa-bolt"></i></div>
                            <div class="about-feature-text">
                                <h4>{{ __('messages.about_feat_2_title') }}</h4>
                                <p>{{ __('messages.about_feat_2_desc') }}</p>
                            </div>
                        </div>
                    </div>

                    <p class="about-text-secondary">
                        {{ __('messages.about_text_2') }}
                    </p>
                </div>

                <div class="about-media">
                    <div class="about-image-container">
                        <!-- Placeholder for illustration -->
                        <div class="about-shape-1"></div>
                        <div class="about-shape-2"></div>
                    </div>
                </div>
            </div>
        </div>
        <section class="cta-section">
            <div class="container">
                <div class="cta-card">
                    <div class="cta-content">
                        <h2 class="cta-title">{{ __('messages.cta_title_1') }} <span class="text-secondary">{{ __('messages.cta_title_2') }}</span>
                        </h2>
                        <p class="cta-subtitle">{{ __('messages.cta_subtitle') }}</p>
                        <div class="cta-actions">
                            <a href="{{ route('register') }}" class="btn btn-secondary btn-lg">{{ __('messages.cta_btn_start') }} <i
                                    class="fa-solid fa-arrow-{{ App::getLocale() == 'ar' ? 'left' : 'right' }}"></i></a>
                            <a href="#Features" class="btn btn-outline-white">{{ __('messages.cta_btn_features') }}</a>
                        </div>
                    </div>
                    <!-- Decorative Background Elements -->
                    <div class="cta-blob cta-blob-1"></div>
                    <div class="cta-blob cta-blob-2"></div>
                </div>
            </div>
        </section>

        <footer class="footer">
            <div class="container">
                <div class="footer-grid">
                    <div class="footer-brand">
                        <a href="{{ route('home') }}" class="footer-logo">
                            <img src="/logo.png" alt="EngHub logo" />
                        </a>
                        <p class="footer-tagline">
                            {{ __('messages.footer_tagline') }}
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fa-brands fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                        </div>
                    </div>

                    <div class="footer-nav">
                        <h4 class="footer-title">{{ __('messages.footer_links_title') }}</h4>
                        <ul class="footer-links">
                            <li><a href="{{ route('home') }}">{{ __('messages.nav_home') }}</a></li>
                            <li><a href="#Features">{{ __('messages.nav_features') }}</a></li>
                            <li><a href="#How-it-works">{{ __('messages.nav_how_it_works') }}</a></li>
                            <li><a href="#About">{{ __('messages.nav_about') }}</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav">
                        <h4 class="footer-title">{{ __('messages.footer_resources_title') }}</h4>
                        <ul class="footer-links">
                            <li><a href="#">{{ __('messages.footer_res_1') }}</a></li>
                            <li><a href="#">{{ __('messages.footer_res_2') }}</a></li>
                            <li><a href="#">{{ __('messages.footer_res_3') }}</a></li>
                            <li><a href="#">{{ __('messages.footer_res_4') }}</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav">
                        <h4 class="footer-title">{{ __('messages.footer_contact_title') }}</h4>
                        <ul class="footer-links">
                            <li><a href="mailto:info@enghub.com"><i class="fa-solid fa-envelope"></i>
                                    info@enghub.com</a></li>
                            <li><a href="#"><i class="fa-solid fa-location-dot"></i> {{ __('messages.footer_contact_faculty') }}</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} {{ __('messages.footer_copyright') }}</p>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
