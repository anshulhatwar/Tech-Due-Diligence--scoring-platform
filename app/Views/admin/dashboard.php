<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CREDENCE Admin Dashboard</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

<header class="navbar">

    <button id="sidebar-toggle" class="hamburger-btn">
        <span class="bar bar1"></span>
        <span class="bar bar2"></span>
        <span class="bar bar3"></span>
    </button>

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

</header>


<div class="app-container">

    <!-- Sidebar -->

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


    <!-- Main Content -->

    <main class="main-content">

        <div class="page-header">

            <h1 class="page-title">CREDENCE Admin Dashboard</h1>

            <p class="page-desc">
                Manage startup assessment applications, evaluator assignments, and certificates
            </p>

        </div>


        <div id="dashboard-message" role="status" style="margin-bottom:15px;"></div>


        <!-- Dashboard Metrics -->

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


        <!-- Applications Table -->

        <div class="card">

            <div class="card-header">

                <h3 class="card-title">Applications Pipeline</h3>

                <button type="button" id="refresh-applications">
                    Refresh
                </button>

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
                            <td colspan="6" style="text-align:center;">
                                Loading applications...
                            </td>
                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

    </main>

</div>


<!-- Evaluation Review Modal -->

<div class="modal-backdrop" id="review-modal">

    <div class="modal-box" style="max-width:750px;max-height:90vh;overflow-y:auto;">

        <div class="modal-header">

            <h3 class="card-title">
                Evaluation Review:
                <span id="review-company"></span>
            </h3>

            <button class="modal-close" onclick="closeReview()">
                &times;
            </button>

        </div>


        <!-- Evaluation Information -->

        <div id="review-loading" style="padding:15px;">
            Loading evaluation details...
        </div>


        <div id="review-content" style="display:none;">

            <div style="background:#f8fafc;padding:15px;border-radius:10px;margin-bottom:20px;border:1px solid #e2e8f0;">

                <p>
                    <strong>Application Number:</strong>
                    <span id="review-app-number">--</span>
                </p>

                <p>
                    <strong>Evaluator:</strong>
                    <span id="review-evaluator">--</span>
                </p>

                <p>
                    <strong>Evaluation Status:</strong>
                    <span id="review-status">--</span>
                </p>

                <p>
                    <strong>Total Score:</strong>

                    <span id="review-score" style="color:var(--primary);font-weight:700;">
                        --
                    </span>
                    / 100

                </p>

                <br>

                <strong>Evaluator Remarks:</strong>

                <p id="review-comments" style="margin-top:8px;">
                    --
                </p>

            </div>


            <!-- Parameter Scores -->

            <h3 style="margin-bottom:12px;">
                Parameter-wise Evaluation
            </h3>


            <div class="table-responsive">

                <table class="custom-table">

                    <thead>
                        <tr>
                            <th>Parameter</th>
                            <th>Weight</th>
                            <th>Score</th>
                            <th>Weighted Score</th>
                        </tr>
                    </thead>

                    <tbody id="review-scores"></tbody>

                </table>

            </div>


            <!-- Admin Remarks -->

            <div class="form-group" style="margin-top:20px;">

                <label class="form-label">
                    Admin Remarks
                </label>

                <textarea
                    id="admin-remarks"
                    class="form-control"
                    placeholder="Enter your decision remarks..."
                ></textarea>

            </div>


            <!-- Decision Buttons -->

            <div style="display:flex;justify-content:flex-end;gap:10px;margin-top:15px;flex-wrap:wrap;">

                <button class="btn btn-secondary" onclick="closeReview()">
                    Cancel
                </button>

                <button
                    class="btn btn-danger"
                    id="reject-button"
                    onclick="rejectReview()"
                >
                    Reject
                </button>

                <button
                    class="btn btn-success"
                    id="approve-button"
                    onclick="approveReview()"
                >
                    Approve
                </button>

            </div>

        </div>

    </div>

</div>


<script>

// ===============================
// API URLS
// ===============================

const adminApplicationsUrl =
    <?= json_encode(base_url('api/admin/applications')) ?>;

const reviewUrl =
    <?= json_encode(base_url('api/admin/evaluations/')) ?>;

const decisionUrl =
    <?= json_encode(base_url('api/admin/evaluations/decision')) ?>;

const logoutUrl =
    <?= json_encode(base_url('api/logout')) ?>;

const loginUrl =
    <?= json_encode(base_url('login')) ?>;


let currentReviewApplicationId = null;
let decisionInProgress = false;


// ===============================
// SIDEBAR
// ===============================

document.getElementById('sidebar-toggle')?.addEventListener('click', function() {

    document.querySelector('.sidebar')?.classList.toggle('collapsed');

    this.classList.toggle('active');

});


// ===============================
// HTML ESCAPE
// ===============================

function escapeHtml(value) {

    return String(value ?? '').replace(/[&<>"']/g, function(char) {

        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];

    });

}


// ===============================
// LOAD APPLICATIONS
// ===============================

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


        // Total Applications

        document.getElementById('total-applications').textContent =
            data.total ?? applications.length;


        // Under Review

        document.getElementById('under-review').textContent =
            applications.filter(app => {

                return ['submitted', 'under review', 'in review', 'under_review']
                    .includes(String(app.status || '').toLowerCase());

            }).length;


        // Approved Applications

        document.getElementById('active-verifications').textContent =
            applications.filter(app => {

                return ['approved', 'verified', 'certified']
                    .includes(String(app.status || '').toLowerCase());

            }).length;


        // Payment Revenue

        document.getElementById('assessment-revenue').textContent = '₹0';


        if (applications.length === 0) {

            table.innerHTML = `
                <tr>
                    <td colspan="6" style="text-align:center;">
                        No applications found.
                    </td>
                </tr>
            `;

            return;

        }


        // Display Applications

        table.innerHTML = applications.map(app => `

            <tr>

                <td>
                    ${escapeHtml(app.company_name || 'Company #' + (app.company_id || 'N/A'))}
                </td>

                <td>
                    ${escapeHtml(app.application_number || 'N/A')}
                </td>

                <td>
                    ${escapeHtml(app.assessment_type || 'N/A')}
                </td>

                <td>
                    <span class="badge badge-new">
                        ${escapeHtml(app.status || 'Submitted')}
                    </span>
                </td>

                <td>
                    ${escapeHtml(app.payment_status || 'Pending')}
                </td>

                <td>

                    <button
                        type="button"
                        class="btn btn-primary btn-sm view-application"
                        data-id="${Number(app.id)}">

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


// ===============================
// VIEW BUTTON
// ===============================

document.getElementById('applications-table').addEventListener('click', function(event) {

    const button = event.target.closest('.view-application');

    if (!button) {
        return;
    }

    openReview(button.dataset.id);

});


// ===============================
// LOAD EVALUATION DETAILS
// ===============================

async function openReview(applicationId) {

    currentReviewApplicationId = Number(applicationId);

    document.getElementById('review-modal').classList.add('active');

    document.getElementById('review-loading').style.display = 'block';

    document.getElementById('review-loading').textContent =
        'Loading evaluation details...';

    document.getElementById('review-content').style.display = 'none';

    document.getElementById('review-company').textContent = 'Loading...';

    try {

        const response = await fetch(reviewUrl + applicationId, {

            method: 'GET',

            credentials: 'same-origin',

            headers: {
                'Accept': 'application/json'
            }

        });

        const data = await response.json();

        if (!response.ok || !data.status) {

            throw new Error(data.message || 'Evaluation not found.');

        }


        const evaluation = data.evaluation;

        const scores = data.scores || [];


        // Company

        document.getElementById('review-company').textContent =
            evaluation.company_name || 'N/A';


        // Application Number

        document.getElementById('review-app-number').textContent =
            evaluation.application_number || 'N/A';


        // Evaluator

        document.getElementById('review-evaluator').textContent =
            evaluation.evaluator_name || 'N/A';


        // Evaluation Status

        document.getElementById('review-status').textContent =
            evaluation.evaluation_status || 'N/A';


        // Total Score

        document.getElementById('review-score').textContent =
            Number(evaluation.total_score || 0).toFixed(2);


        // Evaluator Comments

        document.getElementById('review-comments').textContent =
            evaluation.comments || 'No remarks provided.';


        // Admin Remarks

        document.getElementById('admin-remarks').value =
            evaluation.admin_remarks || '';


        // Parameter Scores

        const scoreTable = document.getElementById('review-scores');

        if (scores.length === 0) {

            scoreTable.innerHTML = `
                <tr>
                    <td colspan="4" style="text-align:center;">
                        No parameter scores found.
                    </td>
                </tr>
            `;

        } else {

            scoreTable.innerHTML = scores.map(item => `

                <tr>

                    <td>
                        ${escapeHtml(item.parameter_name)}
                    </td>

                    <td>
                        ${escapeHtml(item.weight)}%
                    </td>

                    <td>
                        ${escapeHtml(item.score)} / 10
                    </td>

                    <td>
                        ${escapeHtml(item.weighted_score)}
                    </td>

                </tr>

            `).join('');

        }


        // Disable buttons if already reviewed

        const alreadyReviewed = ['Approved', 'Rejected']
            .includes(evaluation.evaluation_status);


        document.getElementById('approve-button').disabled =
            alreadyReviewed;

        document.getElementById('reject-button').disabled =
            alreadyReviewed;

        document.getElementById('admin-remarks').disabled =
            alreadyReviewed;


        if (alreadyReviewed) {

            document.getElementById('approve-button').textContent =
                'Already Reviewed';

            document.getElementById('reject-button').style.display =
                'none';

        } else {

            document.getElementById('approve-button').textContent =
                'Approve';

            document.getElementById('reject-button').style.display =
                'inline-block';

        }


        document.getElementById('review-loading').style.display = 'none';

        document.getElementById('review-content').style.display = 'block';


    } catch (error) {

        document.getElementById('review-loading').textContent =
            error.message;

        document.getElementById('review-company').textContent =
            'Evaluation Details';

    }

}


// ===============================
// CLOSE REVIEW MODAL
// ===============================

function closeReview() {

    document.getElementById('review-modal').classList.remove('active');

    currentReviewApplicationId = null;

    decisionInProgress = false;

}


// ===============================
// APPROVE / REJECT API
// ===============================

async function submitDecision(decision) {

    if (!currentReviewApplicationId || decisionInProgress) {
        return;
    }

    const remarks = document.getElementById('admin-remarks').value.trim();


    const confirmed = confirm(
        'Are you sure you want to ' + decision + ' this application?'
    );

    if (!confirmed) {
        return;
    }


    decisionInProgress = true;

    const approveButton = document.getElementById('approve-button');

    const rejectButton = document.getElementById('reject-button');

    approveButton.disabled = true;

    rejectButton.disabled = true;


    try {

        const response = await fetch(decisionUrl, {

            method: 'POST',

            credentials: 'same-origin',

            headers: {

                'Content-Type': 'application/json',

                'Accept': 'application/json'

            },

            body: JSON.stringify({

                application_id: currentReviewApplicationId,

                decision: decision,

                admin_remarks: remarks

            })

        });


        const data = await response.json();


        if (!response.ok || !data.status) {

            throw new Error(data.message || 'Unable to update decision.');

        }


        alert(data.message || 'Decision updated successfully.');


        closeReview();

        loadApplications();


    } catch (error) {

        alert(error.message);

        approveButton.disabled = false;

        rejectButton.disabled = false;

    } finally {

        decisionInProgress = false;

    }

}


// ===============================
// APPROVE
// ===============================

function approveReview() {

    submitDecision('Approved');

}


// ===============================
// REJECT
// ===============================

function rejectReview() {

    submitDecision('Rejected');

}


// ===============================
// REFRESH
// ===============================

document.getElementById('refresh-applications')?.addEventListener(
    'click',
    loadApplications
);


// ===============================
// LOGOUT
// ===============================

document.getElementById('btn-logout')?.addEventListener('click', async function() {

    try {

        await fetch(logoutUrl, {

            method: 'POST',

            credentials: 'same-origin'

        });

    } finally {

        window.location.href = loginUrl;

    }

});


// ===============================
// INITIAL LOAD
// ===============================

document.addEventListener('DOMContentLoaded', loadApplications);

</script>

</body>
</html>