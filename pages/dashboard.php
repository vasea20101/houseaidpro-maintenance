<?php require_once __DIR__ . '/../includes/config.php'; ?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard — HouseAidPro</title>
    <meta name="description" content="View and track your submitted maintenance issues.">
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
                    Issue</a><a href="dashboard.php" class="nav__link active">Dashboard</a><a href="faq.php"
                    class="nav__link">Help</a>
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
                    <a href="#" class="btn btn--ghost btn--sm" id="logout-btn"
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
                    <h1>My Issues</h1>
                    <p class="text-sm text-muted">Track all your submitted maintenance requests</p>
                </div>
                <a href="report.php" class="btn btn--primary">+ Report New Issue</a>
            </div>

            <div class="stats-grid stagger">
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--blue"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                            <polyline points="14 2 14 8 20 8" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value" id="stat-total">0</div>
                        <div class="stat-card__label">Total Issues</div>
                    </div>
                </div>
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--orange"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <polyline points="12 6 12 12 16 14" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value" id="stat-active">0</div>
                        <div class="stat-card__label">In Progress</div>
                    </div>
                </div>
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--green"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value" id="stat-resolved">0</div>
                        <div class="stat-card__label">Resolved</div>
                    </div>
                </div>
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--red"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path
                                d="M10.29 3.86L1.82 18a2 2 0 0 0 1.71 3h16.94a2 2 0 0 0 1.71-3L13.71 3.86a2 2 0 0 0-3.42 0z" />
                            <line x1="12" y1="9" x2="12" y2="13" />
                            <line x1="12" y1="17" x2="12.01" y2="17" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value" id="stat-urgent">0</div>
                        <div class="stat-card__label">Urgent</div>
                    </div>
                </div>
            </div>

            <div class="card" style="margin-top:var(--space-6)">
                <div class="filters-bar">
                    <input type="text" class="form-input" placeholder="Search issues..." id="search-issues"
                        style="flex:1">
                    <select class="form-select" id="filter-status">
                        <option value="">All Statuses</option>
                        <option value="new">New</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>

                <div class="table-wrap">
                    <table class="table" id="issues-table">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Issue</th>
                                <th>Category</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="issues-tbody">
                            <tr>
                                <td colspan="6"
                                    style="text-align:center;padding:var(--space-8);color:var(--text-muted)">No issues
                                    found. <a href="report.php">Report your first issue</a>.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/app.js"></script>
    <script src="../js/dashboard.js"></script>
</body>

</html>