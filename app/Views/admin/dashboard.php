<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREDENCE Admin Dashboard</title>

```
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
```

</head>
<body>

<header class="navbar">
    <button id="sidebar-toggle" class="hamburger-btn">
        <span class="bar bar1"></span>
        <span class="bar bar2"></span>
        <span class="bar bar3"></span>
    </button>

```
<a href="#" class="brand-logo">
    <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:34px;">
    <div>
        <div class="brand-title">Tech Due-Diligence & Trust Score</div>
        <span class="brand-sub">Verification & Assessment Platform</span>
    </div>
</a>

<div class="nav-controls">
    <div class="nav-user-info">
        <div class="nav-user-avatar">AD</div>
        <span>Admin</span>
    </div>
    <button class="nav-logout-btn" id="btn-logout">Logout</button>
</div>
```

</header>

<div class="app-container">

```
<aside class="sidebar">
    <div class="role-nav">
        <div class="sidebar-title">CREDENCE Admin</div>

        <a class="nav-link active" href="<?= base_url('admin') ?>">
            Applications Overview
        </a>

        <a class="nav-link" href="<?= base_url('admin/params') ?>">
            Assessment Parameters
        </a>

        <a class="nav-link" href="<?= base_url('eval') ?>">
            Assigned Queue
        </a>
    </div>
</aside>

<main class="main-content">

    <div class="page-header">
        <h1 class="page-title">CREDENCE Admin Dashboard</h1>
        <p class="page-desc">
            Manage startup assessment applications, evaluator assignments, and certificates
        </p>
    </div>

    <div id="dashboard-message" role="status" style="margin-bottom:15px;"></div>

    <div class="metrics-grid">

        <div class="metric-card">
            <div class="metric-icon">📋</div>
            <div>
                <div class="metric-val" id="total-applications">0</div>
                <div class="metric-label">Total Applications</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">⏳</div>
            <div>
                <div class="metric-val" id="under-review">0</div>
                <div class="metric-label">Under Review</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">🛡️</div>
            <div>
                <div class="metric-val" id="active-verifications">0</div>
                <div class="metric-label">Active Verifications</div>
            </div>
        </div>

        <div class="metric-card">
            <div class="metric-icon">💰</div>
            <div>
                <div class="metric-val" id="assessment-revenue">₹0</div>
                <div class="metric-label">Assessment Revenue</div>
            </div>
        </div>

    </div>

    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Applications Pipeline</h3>
            <button type="button" id="refresh-applications">Refresh</button>
        </div>

        <div class="table-responsive">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Company</th>
                        <th>Application Number</th>
                        <th>Assessment Type</th>
                        <th>Status</th>
                        <th>Payment</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody id="applications-table">
                    <tr>
                        <td colspan="6" style="text-align:center;color:#64748b;">
                            Loading applications...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>

</main>
```

</div>

<script>
const adminApplicationsUrl = <?= json_encode(base_url('api/admin/applications')) ?>;
const logoutUrl = <?= json_encode(base_url('api/logout')) ?>;
const loginUrl = <?= json_encode(base_url('login')) ?>;

document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
    document.querySelector('.sidebar')?.classList.toggle('collapsed');
    this.classList.toggle('active');
});

function escapeHtml(value) {
    return String(value ?? '').replace(/[&<>"']/g, function (char) {
        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];
    });
}

async function loadApplications() {
    const table = document.getElementById('applications-table');
    const message = document.getElementById('dashboard-message');

    table.innerHTML = `
        <tr>
            <td colspan="6" style="text-align:center;">
                Loading applications...
            </td>
        </tr>
    `;

    message.textContent = '';

    try {
        const response = await fetch(adminApplicationsUrl, {
            method: 'GET',
            credentials: 'same-origin',
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (!response.ok || !data.status) {
            throw new Error(data.message || 'Unable to load applications.');
        }

        const applications = data.applications || [];

        document.getElementById('total-applications').textContent =
            data.total ?? applications.length;

        document.getElementById('under-review').textContent =
            applications.filter(app =>
                ['under review', 'in review', 'under_review'].includes(
                    String(app.status || '').toLowerCase()
                )
            ).length;

        document.getElementById('active-verifications').textContent =
            applications.filter(app =>
                ['verified', 'approved', 'certified'].includes(
                    String(app.status || '').toLowerCase()
                )
            ).length;

        // Revenue will be connected when payment records are available.
        document.getElementById('assessment-revenue').textContent = '₹0';

        if (applications.length === 0) {
            table.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center;color:#64748b;">
                        No applications found.
                    </td>
                </tr>
            `;
            return;
        }

        table.innerHTML = applications.map(app => `
            <tr>
                <td>${escapeHtml(app.company_name || 'Company #' + (app.company_id || 'N/A'))}</td>
                <td>${escapeHtml(app.application_number || 'N/A')}</td>
                <td>${escapeHtml(app.assessment_type || 'N/A')}</td>
                <td>${escapeHtml(app.status || 'Submitted')}</td>
                <td>${escapeHtml(app.payment_status || 'Pending')}</td>
                <td>
                    <button
                        type="button"
                        class="view-application"
                        data-id="${escapeHtml(app.id)}">
                        View
                    </button>
                </td>
            </tr>
        `).join('');

    } catch (error) {
        table.innerHTML = `
            <tr>
                <td colspan="6" style="text-align:center;color:#b91c1c;">
                    Failed to load applications.
                </td>
            </tr>
        `;

        message.textContent = error.message;
    }
}

document.getElementById('applications-table').addEventListener('click', function (event) {
    const button = event.target.closest('.view-application');

    if (!button) {
        return;
    }

    const row = button.closest('tr');

    alert(
        'Application: ' + row.cells[1].textContent +
        '\nCompany: ' + row.cells[0].textContent +
        '\nAssessment: ' + row.cells[2].textContent +
        '\nStatus: ' + row.cells[3].textContent +
        '\nPayment: ' + row.cells[4].textContent
    );
});

document.getElementById('refresh-applications').addEventListener('click', loadApplications);

document.getElementById('btn-logout')?.addEventListener('click', async function () {
    try {
        await fetch(logoutUrl, {
            method: 'POST',
            credentials: 'same-origin'
        });
    } finally {
        window.location.href = loginUrl;
    }
});

document.addEventListener('DOMContentLoaded', loadApplications);
</script>

</body>
</html>
