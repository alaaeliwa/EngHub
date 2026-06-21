<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- Favicon -->
    <link rel="icon" href="images/favicon.ico" />
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
                    <li><a href="{{ route('home') }}" class="nav-link">Home</a></li>
                    <li><a href="#Features" class="nav-link">Features</a></li>
                    <li><a href="#How-it-works" class="nav-link">How it works</a></li>
                    <li><a href="#About" class="nav-link">About</a></li>
                </ul>
                <div class="nav-buttons">
                    <a href="{{ route('login') }}" class="btn btn-outline">Login</a>
                    <a href="{{ route('register') }}" class="btn btn-primary">Get Started</a>
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
                    <div class="hero-badge">Innovative Engineering</div>
                    <h1 class="hero-title">
                        <span class="cursive-text">Your Engineering</span> Knowledge Hub
                        in One Place
                    </h1>
                    <p class="hero-subtitle">
                        Empowering Future Engineers with Essential Skills & Knowledge.
                        Access verified lecture notes, workshops, and peer insights.
                    </p>
                    <div class="hero-actions">
                        <a href="#courses" class="btn btn-primary">Start learning now!</a>
                        <a href="#about" class="btn btn-outline">About Us</a>
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
                                <span>Students Active</span>
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
                <span class="section-badge">Our Core Capabilities</span>
                <h2 class="section-title">Everything You Need to <span class="text-primary">Succeed</span></h2>
                <p class="section-subtitle">A comprehensive platform designed specifically for engineering students to
                    bridge the gap between theory and practice.</p>
            </div>

            <div class="grid grid-cols-4 feature-grid">
                <!-- Feature 1 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-1">
                        <i class="fa-solid fa-book-open"></i>
                    </div>
                    <h3 class="feature-title">Organized Academic Content</h3>
                    <p class="feature-description">Access high-quality lecture notes, study guides, and academic
                        resources organized by department and level.</p>
                    <div class="feature-hover-indicator"></div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-2">
                        <i class="fa-solid fa-hands-helping"></i>
                    </div>
                    <h3 class="feature-title">Community Contributions</h3>
                    <p class="feature-description">Share your own insights and learn from the collective experience of a
                        vibrant engineering community.</p>
                    <div class="feature-hover-indicator"></div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-3">
                        <i class="fa-solid fa-calendar-days"></i>
                    </div>
                    <h3 class="feature-title">Workshops & Events</h3>
                    <p class="feature-description">Stay updated with hands-on workshops, technical seminars, and
                        networking events across various disciplines.</p>
                    <div class="feature-hover-indicator"></div>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card">
                    <div class="feature-icon-wrapper icon-4">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>
                    <h3 class="feature-title">Smart Search System</h3>
                    <p class="feature-description">Quickly find specific topics, authors, or event details using our
                        advanced filtering and intelligent search.</p>
                    <div class="feature-hover-indicator"></div>
                </div>
            </div>
        </div>
    </section>

    <section id="How-it-works" class="how-it-works section">
        <div class="container">
            <div class="section-header text-center">
                <span class="section-badge">Simple & Efficient</span>
                <h2 class="section-title">How It <span class="text-primary">Works</span></h2>
                <p class="section-subtitle">Get started with EngHub in four simple steps and accelerate your engineering
                    journey.</p>
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
                            <h3 class="step-title">Create Account</h3>
                            <p class="step-description">Sign up and join our community of passionate engineering
                                students.</p>
                        </div>
                    </div>

                    <!-- Step 2 -->
                    <div class="step-item">
                        <div class="step-number">02</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-graduation-cap"></i>
                            </div>
                            <h3 class="step-title">Choose Your Path</h3>
                            <p class="step-description">Select your department and academic level to get personalized
                                content.</p>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="step-item">
                        <div class="step-number">03</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-book"></i>
                            </div>
                            <h3 class="step-title">Explore Content</h3>
                            <p class="step-description">Access verified notes, solved exams, and high-quality study
                                materials.</p>
                        </div>
                    </div>

                    <!-- Step 4 -->
                    <div class="step-item">
                        <div class="step-number">04</div>
                        <div class="step-content">
                            <div class="step-icon">
                                <i class="fa-solid fa-calendar-check"></i>
                            </div>
                            <h3 class="step-title">Join Events</h3>
                            <p class="step-description">Participate in workshops and events to enhance your practical
                                skills.</p>
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
                    <span class="section-badge">About the Platform</span>
                    <h2 class="section-title">Empowering the Next Generation of <span
                            class="text-primary">Engineers</span></h2>

                    <p class="about-text">
                        <strong>EngHub</strong> is a web-based learning platform designed specifically for engineering
                        students. It aims to organize and simplify access to academic resources such as summaries, PDFs,
                        videos, and external study materials in one structured place.
                    </p>

                    <div class="about-features">
                        <div class="about-feature-item">
                            <div class="about-feature-icon"><i class="fa-solid fa-users-gear"></i></div>
                            <div class="about-feature-text">
                                <h4>Collaborative Learning</h4>
                                <p>Encourages students to share content, upload notes, and contribute educational
                                    resources.</p>
                            </div>
                        </div>

                        <div class="about-feature-item">
                            <div class="about-feature-icon"><i class="fa-solid fa-bolt"></i></div>
                            <div class="about-feature-text">
                                <h4>Efficiency Driven</h4>
                                <p>Reduces time spent searching and improves learning efficiency through a
                                    community-driven system.</p>
                            </div>
                        </div>
                    </div>

                    <p class="about-text-secondary">
                        EngHub helps bridge the gap between academic theory and practical engineering knowledge through
                        a well-organized and community-driven ecosystem.
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
                        <h2 class="cta-title">Ready to Boost Your <span class="text-secondary">Engineering</span>
                            Journey?</h2>
                        <p class="cta-subtitle">Join thousands of students and access organized academic resources
                            today. Start your path to success with EngHub.</p>
                        <div class="cta-actions">
                            <a href="pages/register.html" class="btn btn-secondary btn-lg">Get Started Now <i
                                    class="fa-solid fa-arrow-right"></i></a>
                            <a href="#Features" class="btn btn-outline-white">Explore Features</a>
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
                        <a href="index.html" class="footer-logo">
                            <img src="images/logo.png" alt="EngHub logo" />
                        </a>
                        <p class="footer-tagline">
                            Empowering future engineers with the best academic resources and a collaborative community.
                        </p>
                        <div class="social-links">
                            <a href="#" class="social-link"><i class="fa-brands fa-linkedin"></i></a>
                            <a href="#" class="social-link"><i class="fa-brands fa-github"></i></a>
                            <a href="#" class="social-link"><i class="fa-brands fa-twitter"></i></a>
                            <a href="#" class="social-link"><i class="fa-brands fa-facebook"></i></a>
                        </div>
                    </div>

                    <div class="footer-nav">
                        <h4 class="footer-title">Quick Links</h4>
                        <ul class="footer-links">
                            <li><a href="index.html">Home</a></li>
                            <li><a href="#Features">Features</a></li>
                            <li><a href="#How-it-works">How it works</a></li>
                            <li><a href="#About">About Us</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav">
                        <h4 class="footer-title">Resources</h4>
                        <ul class="footer-links">
                            <li><a href="#">Lecture Notes</a></li>
                            <li><a href="#">Solved Exams</a></li>
                            <li><a href="#">Workshops</a></li>
                            <li><a href="#">Join Community</a></li>
                        </ul>
                    </div>

                    <div class="footer-nav">
                        <h4 class="footer-title">Contact</h4>
                        <ul class="footer-links">
                            <li><a href="mailto:info@enghub.com"><i class="fa-solid fa-envelope"></i>
                                    info@enghub.com</a></li>
                            <li><a href="#"><i class="fa-solid fa-location-dot"></i> Engineering Faculty</a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; 2026 EngHub. All rights reserved. Designed for Engineering Excellence.</p>
                </div>
            </div>
        </footer>

        <script src="{{ asset('js/main.js') }}"></script>
</body>

</html>
