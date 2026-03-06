<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help & FAQ — HouseAidPro</title>
    <meta name="description"
        content="Frequently asked questions and troubleshooting tips for common maintenance issues.">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/animations.css">
</head>

<body>
    <header class="site-header">
        <div class="header-inner">
            <a href="../index.php" class="logo">
                <div class="logo__icon"><svg viewBox="0 0 24 24" fill="currentColor">
                        <path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z" />
                    </svg></div>
                <div class="logo__text"><span>HouseAidPro</span></div>
            </a>
            <nav class="nav" id="main-nav">
                <a href="../index.php" class="nav__link">Home</a><a href="report.php" class="nav__link">Report
                    Issue</a><a href="faq.php" class="nav__link active">Help & FAQ</a><a href="track.php"
                    class="nav__link">Track Issue</a>
                <div class="nav__actions">
                    <button class="theme-toggle" id="theme-toggle" aria-label="Toggle dark mode"><svg class="icon-moon"
                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z" />
                        </svg><svg class="icon-sun" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <circle cx="12" cy="12" r="5" />
                            <line x1="12" y1="1" x2="12" y2="3" />
                            <line x1="12" y1="21" x2="12" y2="23" />
                            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64" />
                            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78" />
                            <line x1="1" y1="12" x2="3" y2="12" />
                            <line x1="21" y1="12" x2="23" y2="12" />
                            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36" />
                            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22" />
                        </svg></button>
                    <a href="login.php" class="btn btn--outline btn--sm">Log In</a>
                </div>
            </nav>
            <button class="hamburger" id="hamburger" aria-label="Open menu"><svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg></button>
        </div>
    </header>

    <main class="main-content page-enter">
        <div class="container container--lg">
            <div class="section__header" style="margin-bottom:var(--space-8)">
                <p class="section__subtitle">Knowledge Base</p>
                <h1>Help & Frequently Asked Questions</h1>
                <p class="section__desc">Find answers to common questions and troubleshoot minor issues before
                    reporting.</p>
            </div>

            <!-- Search -->
            <div class="form-group" style="max-width:500px;margin:0 auto var(--space-8)">
                <input type="text" class="form-input" id="faq-search" placeholder="🔍 Search for help..."
                    style="text-align:center;font-size:var(--text-lg);padding:var(--space-4)">
            </div>

            <!-- Quick Tips -->
            <div class="grid-3" style="margin-bottom:var(--space-10)">
                <div class="card hover-lift" style="text-align:center">
                    <div style="font-size:40px;margin-bottom:var(--space-3)">🔧</div>
                    <h4>Quick Fix Tips</h4>
                    <p class="text-sm">Simple solutions you can try before reporting — unblocking drains, resetting
                        circuits, etc.</p>
                </div>
                <div class="card hover-lift" style="text-align:center">
                    <div style="font-size:40px;margin-bottom:var(--space-3)">📋</div>
                    <h4>Reporting Guide</h4>
                    <p class="text-sm">How to submit a maintenance report with all the info needed for a quick
                        resolution.</p>
                </div>
                <div class="card hover-lift" style="text-align:center">
                    <div style="font-size:40px;margin-bottom:var(--space-3)">🚨</div>
                    <h4>Emergency Info</h4>
                    <p class="text-sm">When and how to report emergencies like gas leaks, flooding, or fire hazards.</p>
                </div>
            </div>

            <!-- FAQ Accordion -->
            <h2 style="margin-bottom:var(--space-4)">Frequently Asked Questions</h2>

            <div class="accordion" id="faq-accordion">
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">How do I report a maintenance issue?<svg
                            width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body">Click the <strong>"Report Issue"</strong> button on the homepage or
                            in the navigation. You'll be guided through 5 simple steps: describe the problem, upload
                            photos, enter your address, provide contact details, and confirm the submission.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">Do I need an account to report an
                        issue?<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body">No! You can submit a report as a <strong>guest</strong> without
                            creating an account. However, creating an account allows you to track your issues, receive
                            updates, and prefill your details for future reports.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">What types of issues can I report?<svg
                            width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body">You can report any maintenance issue including: plumbing,
                            electrical, appliances, heating, leaks, fencing, doors & windows, roofing, damp & mould,
                            pest control, locks & security, and more. Choose the "Other" category for anything not
                            listed.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">How long does it take to get a
                        response?<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body">Most issues are acknowledged within <strong>24 hours</strong>.
                            Emergency issues are prioritised and routed immediately. You'll receive email or SMS
                            notifications when the status of your issue changes.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">What should I do in an emergency?<svg
                            width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body">For <strong>gas leaks, flooding, fire, or electrical
                                danger</strong>: call <strong>999</strong> immediately. Then contact the emergency
                            maintenance line at <strong>0800 123 4567</strong>. Do NOT use the online reporting form for
                            emergencies.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">Can I track the status of my reported
                        issue?<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body">Yes! Use the <strong>"Track Issue"</strong> page and enter your
                            reference number (sent to you via email after submission). If you have an account, all your
                            issues are visible in your dashboard.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">My tap is dripping — should I report
                        it?<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body"><strong>Quick fix:</strong> Try tightening the tap handle gently.
                            If the drip persists, check if the issue is with the hot or cold water. A worn washer is
                            usually the cause — report it and we'll send a plumber to replace it.</div>
                    </div>
                </div>
                <div class="accordion__item">
                    <button class="accordion__trigger" aria-expanded="false">A circuit breaker keeps tripping — what do
                        I do?<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2">
                            <polyline points="6 9 12 15 18 9" />
                        </svg></button>
                    <div class="accordion__content">
                        <div class="accordion__body"><strong>Quick fix:</strong> Unplug all appliances from the affected
                            circuit, then reset the breaker. Plug items back in one at a time to find the faulty device.
                            If the breaker trips without anything plugged in, report it immediately as it may indicate a
                            wiring fault.</div>
                    </div>
                </div>
            </div>

            <!-- Emergency section -->
            <div class="alert alert--danger"
                style="margin-top:var(--space-10);font-size:var(--text-base);padding:var(--space-6)">
                <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    style="flex-shrink:0">
                    <path
                        d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                    <line x1="12" y1="9" x2="12" y2="13" />
                    <line x1="12" y1="17" x2="12.01" y2="17" />
                </svg>
                <div><strong>Emergency Contact:</strong> For urgent issues call <strong>0800 123 4567</strong> (24/7).
                    For fire, gas, or immediate danger call <strong>999</strong>.</div>
            </div>
        </div>
    </main>

    <script src="../js/app.js"></script>
    <script>
        // FAQ search
        document.getElementById('faq-search').addEventListener('input', function () {
            const q = this.value.toLowerCase();
            document.querySelectorAll('.accordion__item').forEach(item => {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(q) ? '' : 'none';
            });
        });
    </script>
</body>

</html>