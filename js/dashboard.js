/**
 * HouseAidPro — Dashboard JS (dashboard.js)
 */
(function () {
    'use strict';

    async function loadIssues() {
        try {
            const res = await fetch('../api/issues.php?action=my');
            const data = await res.json();
            if (!data.success || !data.issues) return;

            const issues = data.issues;
            document.getElementById('stat-total').textContent = issues.length;
            document.getElementById('stat-active').textContent = issues.filter(i => ['in_progress', 'scheduled'].includes(i.status)).length;
            document.getElementById('stat-resolved').textContent = issues.filter(i => ['completed', 'closed'].includes(i.status)).length;
            document.getElementById('stat-urgent').textContent = issues.filter(i => i.priority === 'emergency').length;

            renderTable(issues);
        } catch {
            // API not available yet — leave default
        }
    }

    function renderTable(issues) {
        const tbody = document.getElementById('issues-tbody');
        if (!issues.length) return;

        const statusBadge = s => {
            const labels = { new: 'New', acknowledged: 'Acknowledged', scheduled: 'Scheduled', in_progress: 'In Progress', completed: 'Completed', closed: 'Closed' };
            return `<span class="badge badge--${s}">${labels[s] || s}</span>`;
        };

        tbody.innerHTML = issues.map(i => `
            <tr>
                <td><span class="issue-row__ref">${i.reference_code}</span></td>
                <td><strong>${i.title}</strong><br><small class="text-muted">${(i.description || '').substring(0, 60)}...</small></td>
                <td>${i.category_name || i.category_id}</td>
                <td>${new Date(i.submitted_at).toLocaleDateString()}</td>
                <td>${statusBadge(i.status)}</td>
                <td><button class="btn btn--ghost btn--sm" onclick="alert('Issue detail view coming soon')">View</button></td>
            </tr>
        `).join('');
    }

    // Filter logic
    const searchInput = document.getElementById('search-issues');
    const filterStatus = document.getElementById('filter-status');

    if (searchInput) {
        searchInput.addEventListener('input', () => {
            const q = searchInput.value.toLowerCase();
            document.querySelectorAll('#issues-tbody tr').forEach(row => {
                row.style.display = row.textContent.toLowerCase().includes(q) ? '' : 'none';
            });
        });
    }

    loadIssues();
})();
