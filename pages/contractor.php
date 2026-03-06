<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contractor Portal — HouseAidPro</title>
    <meta name="description" content="Contractor portal to manage assigned maintenance tasks.">
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
                <a href="contractor.php" class="nav__link active">My Tasks</a>
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
                    <a href="#" class="btn btn--ghost btn--sm"
                        onclick="fetch('../api/auth.php',{method:'POST',body:new URLSearchParams({action:'logout'})}).then(()=>location.href='login.php')">Log
                        Out</a>
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
        <div class="container">
            <div class="dashboard-header">
                <div>
                    <h1>My Assigned Tasks</h1>
                    <p class="text-sm text-muted">Accept jobs, update progress, and upload completion photos</p>
                </div>
            </div>

            <div class="stats-grid" style="grid-template-columns:repeat(3,1fr)">
                <div class="stat-card">
                    <div class="stat-card__icon stat-card__icon--blue"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">3</div>
                        <div class="stat-card__label">Assigned</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon stat-card__icon--orange"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">1</div>
                        <div class="stat-card__label">In Progress</div>
                    </div>
                </div>
                <div class="stat-card">
                    <div class="stat-card__icon stat-card__icon--green"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">12</div>
                        <div class="stat-card__label">Completed</div>
                    </div>
                </div>
            </div>

            <!-- Task Cards -->
            <div class="grid-2" style="margin-top:var(--space-6);" id="contractor-tasks">
                <div class="card animate-fadeInUp">
                    <div class="card__header">
                        <span class="badge badge--new">New Assignment</span>
                        <span class="text-xs text-muted">HAP-20260305-A1B2</span>
                    </div>
                    <h4 style="margin-bottom:var(--space-2)">Leaking kitchen tap</h4>
                    <p class="text-sm">Tenant reports a persistent drip from the hot water tap in the kitchen. Bucket is
                        being emptied daily.</p>
                    <div style="margin-top:var(--space-3);font-size:var(--text-sm);color:var(--text-muted)">
                        📍 12 High Street, London, SW1A 1AA<br>
                        📅 Preferred: 10 March, Morning
                    </div>
                    <div style="display:flex;gap:var(--space-3);margin-top:var(--space-4)">
                        <button class="btn btn--accent btn--sm">✓ Accept</button>
                        <button class="btn btn--danger btn--sm">✕ Decline</button>
                        <button class="btn btn--secondary btn--sm">💬 Message</button>
                    </div>
                </div>

                <div class="card animate-fadeInUp" style="border-left:3px solid var(--color-warning)">
                    <div class="card__header">
                        <span class="badge badge--in_progress">In Progress</span>
                        <span class="text-xs text-muted">HAP-20260228-C3D4</span>
                    </div>
                    <h4 style="margin-bottom:var(--space-2)">Broken front door lock</h4>
                    <p class="text-sm">Lock mechanism jammed — tenant cannot secure the front door. Spare key doesn't
                        work.</p>
                    <div style="margin-top:var(--space-3);font-size:var(--text-sm);color:var(--text-muted)">📍 45 Oak
                        Avenue, Manchester, M1 4BT</div>

                    <div class="form-group" style="margin-top:var(--space-4)">
                        <label class="form-label" for="progress-update">Progress Update</label>
                        <textarea class="form-textarea" id="progress-update" rows="2"
                            placeholder="Describe what you've done so far..."></textarea>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Upload Completion Photo</label>
                        <input type="file" class="form-input" accept="image/*" id="completion-photo"
                            style="padding:var(--space-2)">
                    </div>
                    <div style="display:flex;gap:var(--space-3)">
                        <button class="btn btn--primary btn--sm">📝 Update Progress</button>
                        <button class="btn btn--accent btn--sm">✅ Mark Complete</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="../js/app.js"></script>
</body>

</html>