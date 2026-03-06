<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log In — HouseAidPro</title>
    <meta name="description"
        content="Log in to your HouseAidPro account to track maintenance issues and manage your reports.">
    <link rel="stylesheet" href="../css/variables.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/components.css">
    <link rel="stylesheet" href="../css/layout.css">
    <link rel="stylesheet" href="../css/animations.css">
    <link rel="stylesheet" href="../css/dashboard.css">
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
                    Issue</a><a href="faq.php" class="nav__link">Help & FAQ</a>
                <div class="nav__actions"><button class="theme-toggle" id="theme-toggle"
                        aria-label="Toggle dark mode"><svg class="icon-moon" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
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
                        </svg></button></div>
            </nav>
            <button class="hamburger" id="hamburger" aria-label="Open menu"><svg viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="6" x2="21" y2="6" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="18" x2="21" y2="18" />
                </svg></button>
        </div>
    </header>

    <main class="auth-wrapper page-enter">
        <div class="auth-card animate-fadeInUp">
            <div class="auth-card__header">
                <h2>Welcome Back</h2>
                <p class="text-sm text-muted">Log in to track your maintenance requests</p>
            </div>

            <div id="login-error" class="alert alert--danger hidden" role="alert"></div>

            <form id="login-form" novalidate>
                <div class="form-group">
                    <label class="form-label" for="login-email">Email Address<span class="required">*</span></label>
                    <input type="email" class="form-input" id="login-email" placeholder="you@example.com"
                        autocomplete="email" aria-required="true">
                </div>
                <div class="form-group">
                    <label class="form-label" for="login-password">Password<span class="required">*</span></label>
                    <div class="password-field">
                        <input type="password" class="form-input" id="login-password" placeholder="Your password"
                            autocomplete="current-password" aria-required="true">
                        <button type="button" class="password-toggle" id="login-password-toggle"
                            aria-label="Show password" aria-controls="login-password" aria-pressed="false">Show</button>
                    </div>
                </div>
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:var(--space-5)">
                    <label class="form-check"><input type="checkbox" id="login-remember"><span
                            class="form-check__label">Remember me</span></label>
                    <a href="#" class="text-sm">Forgot password?</a>
                </div>
                <button type="submit" class="btn btn--primary btn--block btn--lg" id="login-btn">Log In</button>
            </form>

            <div class="divider">or</div>

            <a href="report.php" class="btn btn--secondary btn--block">Continue as Guest</a>

            <div class="auth-card__footer">
                Don't have an account? <a href="register.php"><strong>Create one</strong></a>
            </div>
        </div>
    </main>

    <script src="../js/app.js"></script>
    <script>
        const loginPassword = document.getElementById('login-password');
        const loginPasswordToggle = document.getElementById('login-password-toggle');

        if (loginPassword && loginPasswordToggle) {
            loginPasswordToggle.addEventListener('click', function () {
                const isHidden = loginPassword.type === 'password';
                loginPassword.type = isHidden ? 'text' : 'password';
                loginPasswordToggle.textContent = isHidden ? 'Hide' : 'Show';
                loginPasswordToggle.setAttribute('aria-label', isHidden ? 'Hide password' : 'Show password');
                loginPasswordToggle.setAttribute('aria-pressed', String(isHidden));
            });
        }

        document.getElementById('login-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn = document.getElementById('login-btn');
            const errDiv = document.getElementById('login-error');
            errDiv.classList.add('hidden');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner spinner--sm"></span> Logging in...';

            const fd = new FormData();
            fd.append('action', 'login');
            fd.append('email', document.getElementById('login-email').value);
            fd.append('password', document.getElementById('login-password').value);

            try {
                const res = await fetch('../api/auth.php', { method: 'POST', body: fd });
                const data = await res.json();
                if (data.success) {
                    const role = data.user?.role || 'tenant';
                    if (role === 'admin') window.location.href = 'admin.php';
                    else if (role === 'contractor') window.location.href = 'contractor.php';
                    else window.location.href = 'dashboard.php';
                } else {
                    errDiv.textContent = data.message || 'Login failed.';
                    errDiv.classList.remove('hidden');
                    btn.disabled = false;
                    btn.textContent = 'Log In';
                }
            } catch {
                errDiv.textContent = 'Connection error. Please try again.';
                errDiv.classList.remove('hidden');
                btn.disabled = false;
                btn.textContent = 'Log In';
            }
        });
    </script>
</body>

</html>
