<?php require_once __DIR__ . '/includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description"
        content="HouseAidPro — Report maintenance issues quickly. Track repairs, connect with contractors, and get your home fixed faster.">
    <title>HouseAidPro — Smart Maintenance Reporting</title>
    <link rel="manifest" href="manifest.json">
    <meta name="theme-color" content="#3b72e8">
    <link rel="stylesheet" href="css/variables.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/components.css">
    <link rel="stylesheet" href="css/layout.css">
    <link rel="stylesheet" href="css/animations.css">
    <link rel="stylesheet" href="css/wizard.css">
    <link rel="stylesheet" href="css/dashboard.css">
</head>

<body>

    <!-- ═══ Header ═══════════════════════════════════════════ -->
    <header class="site-header" id="site-header">
        <div class="header-inner">
            <a href="index.php" class="logo" id="logo-link">
                <div class="logo__icon">
                    <svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg>
                </div>
                <div class="logo__text"><span>HouseAidPro</span></div>
            </a>

            <nav class="nav" id="main-nav">
                <a href="index.php" class="nav__link active" id="nav-home">Home</a>
                <a href="pages/report.php" class="nav__link" id="nav-report">Report Issue</a>
                <a href="pages/faq.php" class="nav__link" id="nav-faq">Help & FAQ</a>
                <a href="pages/track.php" class="nav__link" id="nav-track">Track Issue</a>
                <div class="nav__actions">
                    <button class="theme-toggle" id="theme-toggle" aria-label="Toggle dark mode">
                        <svg class="icon-moon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg>
                        <svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="5" />
                            <line x1="12" y1="1" x2="12" y2="3" />
                            <line x1="12" y1="21" x2="12" y2="23" />
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                            <line x1="1" y1="12" x2="3" y2="12" />
                            <line x1="21" y1="12" x2="23" y2="12" />
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                        </svg>
                    </button>
                    <a href="pages/login.php" class="btn btn--outline btn--sm" id="nav-login">Log In</a>
                    <a href="pages/report.php" class="btn btn--primary btn--sm" id="nav-cta">Report Now</a>
                </div>
            </nav>

            <button class="hamburger" id="hamburger" aria-label="Open menu">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg>
            </button>
        </div>
    </header>

    <!-- ═══ Hero ══════════════════════════════════════════════ -->
    <section class="hero" id="hero-section">
        <div class="container">
            <p class="section__subtitle animate-fadeIn">Fast • Simple • Reliable</p>
            <h1 class="hero__title animate-fadeInUp">
                Report Maintenance<br><span class="highlight">Issues in Minutes</span>
            </h1>
            <p class="hero__desc animate-fadeInUp" style="animation-delay:0.1s">
                Describe the problem, upload photos, and submit — we'll handle the rest. Track progress from start to
                finish with full transparency.
            </p>
            <div class="hero__actions animate-fadeInUp" style="animation-delay:0.2s">
                <a href="pages/report.php" class="btn btn--primary btn--lg" id="hero-cta">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="12" y1="18" x2="12" y2="12" />
                        <line x1="9" y1="15" x2="15" y2="15" />
                    </svg>
                    Report an Issue
                </a>
                <a href="pages/faq.php" class="btn btn--secondary btn--lg" id="hero-faq">
                    Browse FAQ
                </a>
            </div>
        </div>
    </section>

    <!-- ═══ How It Works ═════════════════════════════════════ -->
    <section class="section" id="how-it-works">
        <div class="container">
            <div class="section__header">
                <p class="section__subtitle">How It Works</p>
                <h2 class="section__title">5 Simple Steps</h2>
                <p class="section__desc">Our guided wizard walks you through everything we need to get your issue
                    resolved quickly.</p>
            </div>
            <div class="grid-3 stagger" style="max-width:900px;margin:0 auto;">
                <div class="card hover-lift animate-fadeInUp">
                    <div class="card__header">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,var(--color-primary),var(--color-primary-dark))">1
                        </div>
                    </div>
                    <h4>Describe the Issue</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Choose a category, describe what's wrong, and
                        tell us if it's in a private or communal area.</p>
                </div>
                <div class="card hover-lift animate-fadeInUp">
                    <div class="card__header">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,hsl(160,70%,45%),hsl(160,70%,35%))">2</div>
                    </div>
                    <h4>Upload Evidence</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Drag and drop photos, videos, or audio
                        recordings — up to 10 files to help us understand the problem.</p>
                </div>
                <div class="card hover-lift animate-fadeInUp">
                    <div class="card__header">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,var(--color-warning),hsl(30,90%,45%))">3</div>
                    </div>
                    <h4>Provide Address</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Use our postcode lookup to quickly fill in your
                        address or type it manually.</p>
                </div>
                <div class="card hover-lift animate-fadeInUp">
                    <div class="card__header">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,hsl(280,60%,55%),hsl(280,60%,40%))">4</div>
                    </div>
                    <h4>Contact Details</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Tell us how to reach you. No account needed —
                        submit as a guest or create one to track progress.</p>
                </div>
                <div class="card hover-lift animate-fadeInUp">
                    <div class="card__header">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,var(--color-success),hsl(145,65%,30%))">5</div>
                    </div>
                    <h4>Confirm & Send</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Review everything, add notes, schedule a time,
                        and hit submit. You'll get a confirmation instantly.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ Emergency ════════════════════════════════════════ -->
    <section class="section"
        style="background:var(--color-danger-bg);border-top:1px solid var(--border-color);border-bottom:1px solid var(--border-color);"
        id="emergency-section">
        <div class="container" style="max-width:700px;">
            <div class="alert alert--danger" style="font-size:var(--text-base);padding:var(--space-6);">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="flex-shrink:0;margin-top:2px">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                <div>
                    <strong
                        style="font-size:var(--text-lg);display:block;margin-bottom:var(--space-2);">Emergency?</strong>
                    If you have a <strong>gas leak</strong>, <strong>flooding</strong>, <strong>fire</strong>, or
                    <strong>electrical danger</strong>, do NOT use this form.
                    Call <strong style="font-size:var(--text-xl)">999</strong> immediately or your emergency maintenance
                    line:
                    <strong style="font-size:var(--text-xl);display:block;margin-top:var(--space-3);">0800 123
                        4567</strong>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ Features ═════════════════════════════════════════ -->
    <section class="section" id="features-section">
        <div class="container">
            <div class="section__header">
                <p class="section__subtitle">Features</p>
                <h2 class="section__title">Built for Speed & Transparency</h2>
            </div>
            <div class="grid-3 stagger">
                <div class="card hover-lift animate-fadeInUp">
                    <div class="avatar avatar--lg"
                        style="margin-bottom:var(--space-4);background:linear-gradient(135deg,var(--color-primary),var(--color-accent));">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                        </svg>
                    </div>
                    <h4>Secure Submissions</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Your data is encrypted and stored securely.
                        Only authorised staff can view your reports.</p>
                </div>
                <div class="card hover-lift animate-fadeInUp">
                    <div class="avatar avatar--lg"
                        style="margin-bottom:var(--space-4);background:linear-gradient(135deg,var(--color-warning),hsl(30,90%,45%));">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </div>
                    <h4>Real-Time Tracking</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Watch your issue progress from submission to
                        completion with live status updates and notifications.</p>
                </div>
                <div class="card hover-lift animate-fadeInUp">
                    <div class="avatar avatar--lg"
                        style="margin-bottom:var(--space-4);background:linear-gradient(135deg,hsl(280,60%,55%),hsl(280,50%,40%));">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2" />
                            <line x1="16" y1="2" x2="16" y2="6" />
                            <line x1="8" y1="2" x2="8" y2="6" />
                            <line x1="3" y1="10" x2="21" y2="10" />
                        </svg>
                    </div>
                    <h4>Flexible Scheduling</h4>
                    <p class="text-sm" style="margin-top:var(--space-2)">Choose your preferred repair date and time.
                        We'll work around your schedule.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ═══ Footer ═══════════════════════════════════════════ -->
    <footer class="site-footer" id="site-footer">
        <div class="container">
            <div class="footer-grid">
                <div class="footer-brand">
                    <a href="index.php" class="logo">
                        <div class="logo__icon"><svg viewBox="0 0 24 24" fill="currentColor">
                                <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                            </svg></div>
                        <div class="logo__text"><span>HouseAidPro</span></div>
                    </a>
                    <p>Smart maintenance reporting for tenants and homeowners. Get issues resolved faster with full
                        transparency.</p>
                </div>
                <div class="footer-col">
                    <h4>Quick Links</h4>
                    <a href="pages/report.php">Report Issue</a>
                    <a href="pages/track.php">Track Issue</a>
                    <a href="pages/faq.php">Help & FAQ</a>
                </div>
                <div class="footer-col">
                    <h4>Account</h4>
                    <a href="pages/login.php">Log In</a>
                    <a href="pages/register.php">Register</a>
                    <a href="pages/dashboard.php">Dashboard</a>
                </div>
                <div class="footer-col">
                    <h4>Emergency</h4>
                    <a href="tel:08001234567">0800 123 4567</a>
                    <a href="mailto:emergency@houseaidpro.com">emergency@houseaidpro.com</a>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; 2026 HouseAidPro. All rights reserved.</span>
                <span>Terms &amp; Conditions · Privacy Policy</span>
            </div>
        </div>
    </footer>

    <script src="js/app.js"></script>
</body>

</html>