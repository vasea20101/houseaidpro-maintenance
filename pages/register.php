<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account — HouseAidPro</title>
    <meta name="description"
        content="Create a HouseAidPro account to track your maintenance issues and receive updates.">
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
                <h2>Create Your Account</h2>
                <p class="text-sm text-muted">Track issues and receive updates automatically</p>
            </div>
            <div id="reg-error" class="alert alert--danger hidden" role="alert"></div>
            <form id="register-form" novalidate>
                <div class="grid-2">
                    <div class="form-group"><label class="form-label" for="reg-firstname">First Name<span
                                class="required">*</span></label><input type="text" class="form-input"
                            id="reg-firstname" aria-required="true"></div>
                    <div class="form-group"><label class="form-label" for="reg-surname">Surname<span
                                class="required">*</span></label><input type="text" class="form-input" id="reg-surname"
                            aria-required="true"></div>
                </div>
                <div class="form-group"><label class="form-label" for="reg-email">Email<span
                            class="required">*</span></label><input type="email" class="form-input" id="reg-email"
                        autocomplete="email" aria-required="true"></div>
                <div class="form-group"><label class="form-label" for="reg-phone">Phone</label><input type="tel"
                        class="form-input" id="reg-phone"></div>
                <div class="form-group"><label class="form-label" for="reg-password">Password<span
                            class="required">*</span></label><input type="password" class="form-input" id="reg-password"
                        minlength="8" placeholder="Minimum 8 characters" aria-required="true"></div>
                <div class="form-group"><label class="form-label" for="reg-password2">Confirm Password<span
                            class="required">*</span></label><input type="password" class="form-input"
                        id="reg-password2" aria-required="true"></div>
                <button type="submit" class="btn btn--primary btn--block btn--lg" id="reg-btn">Create Account</button>
            </form>
            <div class="auth-card__footer">Already have an account? <a href="login.php"><strong>Log In</strong></a>
            </div>
        </div>
    </main>

    <script src="../js/app.js"></script>
    <script>
        document.getElementById('register-form').addEventListener('submit', async function (e) {
            e.preventDefault();
            const btn = document.getElementById('reg-btn');
            const errDiv = document.getElementById('reg-error');
            errDiv.classList.add('hidden');

            const pw = document.getElementById('reg-password').value;
            const pw2 = document.getElementById('reg-password2').value;
            if (pw.length < 8) { errDiv.textContent = 'Password must be at least 8 characters.'; errDiv.classList.remove('hidden'); return; }
            if (pw !== pw2) { errDiv.textContent = 'Passwords do not match.'; errDiv.classList.remove('hidden'); return; }

            btn.disabled = true;
            btn.innerHTML = '<span class="spinner spinner--sm"></span> Creating...';

            const fd = new FormData();
            fd.append('action', 'register');
            fd.append('first_name', document.getElementById('reg-firstname').value);
            fd.append('surname', document.getElementById('reg-surname').value);
            fd.append('email', document.getElementById('reg-email').value);
            fd.append('phone', document.getElementById('reg-phone').value);
            fd.append('password', pw);

            try {
                const res = await fetch('../api/auth.php', { method: 'POST', body: fd });
                const data = await res.json();
                if (data.success) { window.location.href = 'dashboard.php'; }
                else { errDiv.textContent = data.message || 'Registration failed.'; errDiv.classList.remove('hidden'); btn.disabled = false; btn.textContent = 'Create Account'; }
            } catch {
                errDiv.textContent = 'Connection error.'; errDiv.classList.remove('hidden'); btn.disabled = false; btn.textContent = 'Create Account';
            }
        });
    </script>
</body>

</html>