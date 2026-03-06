<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Your Issue — HouseAidPro</title>
    <meta name="description" content="Track the status of your maintenance issue using your reference number.">
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
                    Issue</a><a href="faq.php" class="nav__link">Help & FAQ</a><a href="track.php"
                    class="nav__link active">Track Issue</a>
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
        <div class="container container--md">
            <div style="text-align:center;margin-bottom:var(--space-8)">
                <h1>Track Your Issue</h1>
                <p class="text-muted">Enter your reference number to view the current status</p>
            </div>

            <div class="card" style="max-width:500px;margin:0 auto">
                <div class="form-group">
                    <label class="form-label" for="track-ref">Reference Number</label>
                    <input type="text" class="form-input" id="track-ref" placeholder="e.g. HAP-20260305-A3X9"
                        style="font-family:var(--font-mono);font-size:var(--text-lg);text-align:center;letter-spacing:0.05em">
                    <span class="form-hint">You received this via email after submitting your report.</span>
                </div>
                <button class="btn btn--primary btn--block btn--lg" id="track-btn">Track Issue</button>
            </div>

            <!-- Results (hidden by default) -->
            <div class="hidden" id="track-result" style="margin-top:var(--space-8)">
                <div class="card animate-fadeInUp">
                    <div class="card__header">
                        <h3 id="track-title">Issue Title</h3>
                        <span class="badge" id="track-status">Status</span>
                    </div>

                    <!-- Timeline -->
                    <div style="margin-top:var(--space-6)">
                        <h4
                            style="margin-bottom:var(--space-4);font-size:var(--text-sm);color:var(--text-muted);text-transform:uppercase;letter-spacing:0.05em;">
                            Progress Timeline</h4>
                        <div id="track-timeline"
                            style="border-left:3px solid var(--border-color);margin-left:var(--space-4);padding-left:var(--space-6);">
                            <!-- Populated by JS -->
                        </div>
                    </div>

                    <div class="grid-2" style="margin-top:var(--space-6)">
                        <div>
                            <p class="text-sm text-muted">Category</p>
                            <p class="text-sm" id="track-category" style="font-weight:var(--weight-medium)">—</p>
                        </div>
                        <div>
                            <p class="text-sm text-muted">Submitted</p>
                            <p class="text-sm" id="track-date" style="font-weight:var(--weight-medium)">—</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="hidden" id="track-not-found" style="margin-top:var(--space-6)">
                <div class="alert alert--warning">Issue not found. Please check the reference number and try again.
                </div>
            </div>
        </div>
    </main>

    <script src="../js/app.js"></script>
    <script>
        document.getElementById('track-btn').addEventListener('click', async () => {
            const ref = document.getElementById('track-ref').value.trim().toUpperCase();
            if (!ref) return;

            document.getElementById('track-result').classList.add('hidden');
            document.getElementById('track-not-found').classList.add('hidden');

            try {
                const res = await fetch('../api/issues.php?action=track&ref=' + encodeURIComponent(ref));
                const data = await res.json();

                if (data.success && data.issue) {
                    const issue = data.issue;
                    document.getElementById('track-title').textContent = issue.title;
                    document.getElementById('track-status').textContent = issue.status.replace('_', ' ');
                    document.getElementById('track-status').className = 'badge badge--' + issue.status;
                    document.getElementById('track-category').textContent = issue.category_name || issue.category_id;
                    document.getElementById('track-date').textContent = new Date(issue.submitted_at).toLocaleDateString();

                    // Build timeline
                    const steps = ['new', 'acknowledged', 'scheduled', 'in_progress', 'completed'];
                    const labels = { new: 'Submitted', acknowledged: 'Acknowledged', scheduled: 'Scheduled', in_progress: 'In Progress', completed: 'Completed' };
                    const currentIdx = steps.indexOf(issue.status);
                    document.getElementById('track-timeline').innerHTML = steps.map((s, i) => {
                        const done = i <= currentIdx;
                        const color = done ? 'var(--color-success)' : 'var(--text-muted)';
                        return `<div style="position:relative;padding-bottom:var(--space-5)">
                    <div style="position:absolute;left:-31px;top:2px;width:14px;height:14px;border-radius:50%;background:${done ? 'var(--color-success)' : 'var(--border-color)'};border:2px solid ${done ? 'var(--color-success)' : 'var(--border-color)'}"></div>
                    <p style="font-weight:${done ? '600' : '400'};color:${color};font-size:var(--text-sm)">${labels[s]}</p>
                    ${i === currentIdx ? '<p class="text-xs text-muted">← Current status</p>' : ''}
                </div>`;
                    }).join('');

                    document.getElementById('track-result').classList.remove('hidden');
                } else {
                    document.getElementById('track-not-found').classList.remove('hidden');
                }
            } catch {
                document.getElementById('track-not-found').classList.remove('hidden');
            }
        });
    </script>
</body>

</html>