<?php
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../includes/auth.php';
requireAdmin();
?>
<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard — HouseAidPro</title>
    <meta name="description" content="Admin panel for managing maintenance issues, contractors, and schedules.">
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
                <a href="admin.php" class="nav__link active">Dashboard</a>
                <a href="#" class="nav__link" onclick="showTab('issues')">Issues</a>
                <a href="#" class="nav__link" onclick="showTab('contractors')">Contractors</a>
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
                    <h1>Admin Dashboard</h1>
                    <p class="text-sm text-muted">Manage issues, assign contractors, update statuses</p>
                </div>
            </div>

            <div class="stats-grid stagger">
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--blue"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">24</div>
                        <div class="stat-card__label">Total Issues</div>
                    </div>
                </div>
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--orange"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <circle cx="12" cy="12" r="10" />
                            <line x1="12" y1="8" x2="12" y2="12" />
                            <line x1="12" y1="16" x2="12.01" y2="16" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">8</div>
                        <div class="stat-card__label">Pending</div>
                    </div>
                </div>
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--green"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">14</div>
                        <div class="stat-card__label">Completed</div>
                    </div>
                </div>
                <div class="stat-card animate-fadeInUp">
                    <div class="stat-card__icon stat-card__icon--red"><svg width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                            <circle cx="9" cy="7" r="4" />
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                            <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                        </svg></div>
                    <div>
                        <div class="stat-card__value">5</div>
                        <div class="stat-card__label">Contractors</div>
                    </div>
                </div>
            </div>

            <!-- Issues Tab -->
            <div id="tab-issues" class="card" style="margin-top:var(--space-6)">
                <div class="card__header">
                    <h3 class="card__title">All Issues</h3>
                </div>
                <div class="filters-bar">
                    <input type="text" class="form-input" placeholder="Search..." id="admin-search">
                    <select class="form-select" id="admin-filter-status">
                        <option value="">All</option>
                        <option value="new">New</option>
                        <option value="acknowledged">Acknowledged</option>
                        <option value="scheduled">Scheduled</option>
                        <option value="in_progress">In Progress</option>
                        <option value="completed">Completed</option>
                        <option value="closed">Closed</option>
                    </select>
                    <select class="form-select" id="admin-filter-priority">
                        <option value="">All Priorities</option>
                        <option value="low">Low</option>
                        <option value="medium">Medium</option>
                        <option value="high">High</option>
                        <option value="emergency">Emergency</option>
                    </select>
                </div>
                <div class="table-wrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Ref</th>
                                <th>Issue</th>
                                <th>Tenant</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th>Assigned</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="admin-issues-tbody">
                            <tr>
                                <td colspan="7" class="text-center text-muted" style="padding:var(--space-8)">Loading
                                    issues...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Contractors Tab (hidden initially) -->
            <div id="tab-contractors" class="hidden" style="margin-top:var(--space-6)">
                <div class="card__header" style="margin-bottom:var(--space-4)">
                    <h3>Contractors</h3>
                </div>
                <div class="grid-3">
                    <div class="contractor-card animate-fadeInUp">
                        <div class="avatar">JD</div>
                        <div class="contractor-card__info">
                            <div class="contractor-card__name">John Davis</div>
                            <div class="contractor-card__spec">Plumbing, Heating</div>
                            <div class="text-xs text-muted">⭐ 4.8 · 12 jobs</div>
                        </div>
                        <span class="badge badge--completed">Available</span>
                    </div>
                    <div class="contractor-card animate-fadeInUp">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,var(--color-warning),hsl(30,90%,40%))">SM</div>
                        <div class="contractor-card__info">
                            <div class="contractor-card__name">Sarah Mitchell</div>
                            <div class="contractor-card__spec">Electrical, Security</div>
                            <div class="text-xs text-muted">⭐ 4.9 · 18 jobs</div>
                        </div>
                        <span class="badge badge--completed">Available</span>
                    </div>
                    <div class="contractor-card animate-fadeInUp">
                        <div class="avatar"
                            style="background:linear-gradient(135deg,hsl(280,60%,55%),hsl(280,50%,40%))">RK</div>
                        <div class="contractor-card__info">
                            <div class="contractor-card__name">Robert King</div>
                            <div class="contractor-card__spec">Roofing, Fencing</div>
                            <div class="text-xs text-muted">⭐ 4.6 · 9 jobs</div>
                        </div>
                        <span class="badge badge--in_progress">Busy</span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="../js/app.js"></script>
    <script>
        function showTab(tab) {
            document.getElementById('tab-issues').classList.toggle('hidden', tab !== 'issues');
            document.getElementById('tab-contractors').classList.toggle('hidden', tab !== 'contractors');
        }

        // Load admin issues
        (async function () {
            try {
                const res = await fetch('../api/issues.php?action=all');
                const data = await res.json();
                if (data.success && data.issues && data.issues.length) {
                    const tbody = document.getElementById('admin-issues-tbody');
                    const badge = s => `<span class="badge badge--${s}">${s.replace('_', ' ')}</span>`;
                    tbody.innerHTML = data.issues.map(i => `<tr>
                <td><span class="issue-row__ref">${i.reference_code}</span></td>
                <td>${i.title}</td>
                <td>${i.first_name || ''} ${i.surname || ''}</td>
                <td>${i.category_name || ''}</td>
                <td>${badge(i.status)}</td>
                <td>${i.contractor_name || '<em class="text-muted">Unassigned</em>'}</td>
                <td><select class="form-select" style="min-width:120px;padding:var(--space-1) var(--space-2);font-size:var(--text-xs)" onchange="updateStatus(${i.id},this.value)"><option ${i.status === 'new' ? 'selected' : ''} value="new">New</option><option ${i.status === 'acknowledged' ? 'selected' : ''} value="acknowledged">Acknowledged</option><option ${i.status === 'scheduled' ? 'selected' : ''} value="scheduled">Scheduled</option><option ${i.status === 'in_progress' ? 'selected' : ''} value="in_progress">In Progress</option><option ${i.status === 'completed' ? 'selected' : ''} value="completed">Completed</option><option ${i.status === 'closed' ? 'selected' : ''} value="closed">Closed</option></select></td>
            </tr>`).join('');
                }
            } catch { }
        })();

        async function updateStatus(issueId, status) {
            try {
                await fetch('../api/issues.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({ action: 'update_status', issue_id: issueId, status: status })
                });
            } catch { }
        }
    </script>
</body>

</html>