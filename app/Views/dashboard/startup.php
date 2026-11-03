<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Startup Dashboard — Credence</title>

    <meta name="description"
          content="Credence Tech Due-Diligence & Trust Score Platform — Startup Dashboard">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap"
          rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

    <!-- Background Video -->
    <video class="bg-video" autoplay muted loop playsinline>
        <source src="<?= base_url('videos/bg.mp4') ?>" type="video/mp4">
    </video>

    <div class="bg-overlay"></div>

    <div class="app-wrapper active" id="app-wrapper">

        <!-- Header -->
        <header class="navbar">

            <button id="sidebar-toggle" class="hamburger-btn" type="button">
                <span class="bar bar1"></span>
                <span class="bar bar2"></span>
                <span class="bar bar3"></span>
            </button>

            <a href="<?= base_url('dashboard') ?>" class="brand-logo">

                <img src="<?= base_url('images/logo.png') ?>"
                     alt="Credence"
                     style="height:34px;">

                <div>
                    <div class="brand-title">
                        Tech Due-Diligence & Trust Score
                    </div>

                    <span class="brand-sub">
                        Verification & Assessment Platform
                    </span>
                </div>

            </a>

            <div class="nav-controls">

                <!-- User Info -->
                <div class="nav-user-info">

                    <div class="nav-user-avatar">
                        <?= esc($userInitials ?? 'U') ?>
                    </div>

                    <span>
                        <?= esc($userName ?? 'User') ?>
                    </span>

                </div>

                <button class="nav-logout-btn"
                        id="btn-logout"
                        type="button">
                    Logout
                </button>

            </div>

        </header>

        <div class="app-container">

            <!-- Sidebar -->
            <aside class="sidebar">

                <div class="role-nav role-startup">

                    <div class="sidebar-title">
                        Startup Portal
                    </div>

                    <a class="nav-link active"
                       href="<?= base_url('dashboard') ?>">

                        <svg width="17" height="17"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>

                        </svg>

                        Dashboard & Status
                    </a>

                    <a class="nav-link"
                       data-view="startup-profile"
                       id="nav-link-profile"
                       href="<?= base_url('profile') ?>">

                        <svg width="17" height="17"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                            </path>

                        </svg>

                        Company Profile
                    </a>

                    <a class="nav-link"
                       data-view="startup-docs"
                       id="nav-link-docs"
                       href="<?= base_url('documents') ?>">

                        <svg width="17" height="17"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>

                        </svg>

                        Document Manager
                    </a>

                    <a class="nav-link"
                       data-view="startup-apply"
                       id="nav-link-apply"
                       href="<?= base_url('apply') ?>">

                        <svg width="17" height="17"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>

                        </svg>

                        Assessment Application
                    </a>

                </div>

                <div style="margin-top:auto;padding-top:1.5rem;border-top:1px solid var(--light-border);">

                    <button class="btn btn-secondary btn-sm"
                            style="width:100%;"
                            onclick="AppStore.resetDB()"
                            type="button">

                        <svg width="14" height="14"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                            </path>

                        </svg>

                        Reset All Data
                    </button>

                </div>

            </aside>

            <!-- Main Content -->
            <main class="main-content">

                <section id="startup-dashboard" class="view-section active">

                    <!-- Page Header -->
                    <div class="page-header">

                        <div style="display:flex;justify-content:space-between;align-items:center;">

                            <div>

                                <h1 class="page-title" id="st-comp-name">
                                    <?= esc($companyName ?? 'My Company') ?>
                                </h1>

                                <p class="page-desc">
                                    Credence Assessment Portal & Application Status Tracker
                                </p>

                            </div>

                            <span class="badge badge-new" id="st-app-status-badge">
                                <?= esc($applicationStatus ?? 'Registered') ?>
                            </span>

                        </div>

                    </div>

                    <!-- Metrics -->
                    <div class="metrics-grid">

                        <div class="metric-card">

                            <div class="metric-icon">📊</div>

                            <div>
                                <div class="metric-val">
                                    <?= esc($profileCompletion ?? 0) ?>%
                                </div>

                                <div class="metric-label">
                                    Profile Completion
                                </div>
                            </div>

                        </div>

                        <div class="metric-card">

                            <div class="metric-icon">📄</div>

                            <div>
                                <div class="metric-val">
                                    <?= esc($documentsCount ?? 0) ?>/3
                                </div>

                                <div class="metric-label">
                                    Documents Uploaded
                                </div>
                            </div>

                        </div>

                        <div class="metric-card">

                            <div class="metric-icon">⏱️</div>

                            <div>
                                <div class="metric-val">
                                    Step <?= esc($workflowStage ?? 2) ?>/8
                                </div>

                                <div class="metric-label">
                                    Workflow Stage
                                </div>
                            </div>

                        </div>

                        <div class="metric-card">

                            <div class="metric-icon">🛡️</div>

                            <div>
                                <div class="metric-val">
                                    <?= esc($verificationStatus ?? 'Pending') ?>
                                </div>

                                <div class="metric-label">
                                    Verification Status
                                </div>
                            </div>

                        </div>

                    </div>

                    <!-- Workflow Progress -->
                    <div class="workflow-wizard">

                        <div class="workflow-wizard-title">
                            Assessment Workflow Progress
                        </div>

                        <div class="wizard-steps-8" id="wizard-steps-8">

                            <div class="wizard-progress-fill"
                                 id="wizard-progress-fill"
                                 style="width:0%;">
                            </div>

                            <div class="wizard-step-8 completed" data-step="1">
                                <div class="step-8-circle">✓</div>
                                <div class="step-8-label">Registration</div>
                            </div>

                            <div class="wizard-step-8 active" data-step="2">
                                <div class="step-8-circle">2</div>
                                <div class="step-8-label">Company Profile</div>
                            </div>

                            <div class="wizard-step-8 locked" data-step="3">
                                <div class="step-8-circle">3</div>
                                <div class="step-8-label">Documents</div>
                            </div>

                            <div class="wizard-step-8 locked" data-step="4">
                                <div class="step-8-circle">4</div>
                                <div class="step-8-label">Assessment Application</div>
                            </div>

                            <div class="wizard-step-8 locked" data-step="5">
                                <div class="step-8-circle">5</div>
                                <div class="step-8-label">Evaluator Assignment</div>
                            </div>

                            <div class="wizard-step-8 locked" data-step="6">
                                <div class="step-8-circle">6</div>
                                <div class="step-8-label">Evaluation & Scoring</div>
                            </div>

                            <div class="wizard-step-8 locked" data-step="7">
                                <div class="step-8-circle">7</div>
                                <div class="step-8-label">Credence Review</div>
                            </div>

                            <div class="wizard-step-8 locked" data-step="8">
                                <div class="step-8-circle">8</div>
                                <div class="step-8-label">Certification & QR</div>
                            </div>

                        </div>

                    </div>

                    <!-- Evaluation Status Card -->
                    <div class="card" id="evaluation-status-card">

                        <div class="card-header">

                            <h3 class="card-title">
                                Evaluation Status
                            </h3>

                            <span class="badge badge-new" id="eval-status-badge">
                                <?= esc($evaluationStatus ?? 'Not Started') ?>
                            </span>

                        </div>

                        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1rem;margin-top:0.5rem;">

                            <div>

                                <div style="font-size:0.8rem;color:#64748b;font-weight:600;text-transform:uppercase;">
                                    Application
                                </div>

                                <div style="font-weight:700;" id="eval-app-status">
                                    <?= esc($applicationStatus ?? 'Not Submitted') ?>
                                </div>

                            </div>

                            <div>

                                <div style="font-size:0.8rem;color:#64748b;font-weight:600;text-transform:uppercase;">
                                    Evaluator
                                </div>

                                <div style="font-weight:700;" id="eval-evaluator">
                                    <?= esc($evaluatorName ?? 'Not Assigned') ?>
                                </div>

                            </div>

                            <div>

                                <div style="font-size:0.8rem;color:#64748b;font-weight:600;text-transform:uppercase;">
                                    Evaluation
                                </div>

                                <div style="font-weight:700;" id="eval-scoring">
                                    <?= esc($evaluationStatus ?? 'Pending') ?>
                                </div>

                            </div>

                            <div>

                                <div style="font-size:0.8rem;color:#64748b;font-weight:600;text-transform:uppercase;">
                                    Final Score
                                </div>

                                <div style="font-weight:700;color:var(--primary);" id="eval-final-score">
                                    <?= esc($finalScore ?? '-- / 100') ?>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Verified Directory Card -->
                    <div class="card" id="directory-card">

                        <div class="card-header">

                            <h3 class="card-title">
                                Verified Directory
                            </h3>

                            <span class="badge badge-active">
                                Public
                            </span>

                        </div>

                        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:1rem;">

                            <input type="text"
                                   id="dir-search"
                                   class="form-control"
                                   placeholder="Search by company name..."
                                   style="flex:1;min-width:200px;">

                            <select id="dir-industry"
                                    class="form-select"
                                    style="width:220px;">

                                <option value="">All Industries</option>
                                <option value="DeepTech / AI">DeepTech / AI</option>
                                <option value="FinTech">FinTech</option>
                                <option value="HealthTech / MedTech">HealthTech / MedTech</option>

                            </select>

                        </div>

                        <div class="table-responsive">

                            <table class="custom-table">

                                <thead>
                                    <tr>
                                        <th>Company</th>
                                        <th>Industry</th>
                                        <th>Score</th>
                                        <th>Verification ID</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>

                                <tbody id="dir-body"></tbody>

                            </table>

                        </div>

                        <div id="dir-empty" class="empty-state">

                            <div class="empty-state-icon">🔍</div>

                            <h3>No Verified Companies Found</h3>

                            <p>
                                Approved companies will appear here.
                            </p>

                        </div>

                    </div>

                    <!-- Certificate Card -->
                    <div class="card"
                         id="certificate-card"
                         style="display:none;border:2px solid var(--primary);">

                        <div class="card-header">

                            <h3 class="card-title" style="color:var(--primary);">
                                Certificate Issued
                            </h3>

                            <span class="badge badge-active">
                                Active
                            </span>

                        </div>

                        <div style="display:grid;grid-template-columns:1fr auto;gap:2rem;align-items:center;">

                            <div>

                                <div style="font-size:0.8rem;color:#64748b;font-weight:600;text-transform:uppercase;">
                                    Verification ID
                                </div>

                                <div style="font-family:monospace;font-size:1.4rem;font-weight:700;color:var(--primary);"
                                     id="cert-ver-id">
                                    --
                                </div>

                                <p style="font-size:0.9rem;color:#334155;margin-top:10px;">
                                    Your Credence Trust Score certificate has been approved.
                                    This verification ID and QR code will be used for public verification.
                                </p>

                            </div>

                            <div id="cert-qr"
                                 style="padding:12px;background:#fff;border:2px solid var(--primary);border-radius:8px;text-align:center;">

                                <div style="font-size:0.8rem;color:#64748b;">
                                    QR Code
                                </div>

                                <div style="font-weight:700;font-family:monospace;"
                                     id="cert-qr-text">
                                    --
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Verification Summary Card -->
                    <div class="card"
                         id="st-cert-summary-card"
                         style="border:2px solid var(--primary);display:none;">

                        <div class="card-header">

                            <h3 class="card-title" style="color:var(--primary);">

                                <svg width="22" height="22"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                    </path>

                                </svg>

                                Assessment Result & Verification Active

                            </h3>

                            <div>

                                <button class="btn btn-secondary btn-sm"
                                        onclick="AppStore.exportPDFReport()">
                                    Download PDF Report
                                </button>

                                <button class="btn btn-primary btn-sm"
                                        onclick="AppStore.viewPublicCert()"
                                        style="margin-left:6px;">
                                    View Public Badge
                                </button>

                            </div>

                        </div>

                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:2rem;">

                            <div>

                                <div style="font-size:0.9rem;color:#64748b;font-weight:600;">
                                    OVERALL ASSESSMENT SCORE
                                </div>

                                <div style="font-family:'Outfit',sans-serif;font-size:3.2rem;font-weight:800;color:var(--primary);"
                                     id="st-score-val">

                                    <?= esc($finalScore ?? '-- / 100') ?>

                                </div>

                                <p style="font-size:0.88rem;color:#334155;margin-bottom:12px;">

                                    <strong>Verification ID:</strong>

                                    <code id="st-ver-id-val">--</code>

                                    <br>

                                    <span id="st-ver-valid-val">--</span>

                                </p>

                                <div style="margin-top:1.5rem;">

                                    <h4 style="font-size:0.95rem;font-weight:700;margin-bottom:8px;">
                                        Parameter Breakdown
                                    </h4>

                                    <div id="st-score-breakdown-bars"></div>

                                </div>

                            </div>

                            <div>

                                <h4 style="font-size:0.95rem;font-weight:700;margin-bottom:8px;text-align:center;">
                                    Radar Assessment Matrix
                                </h4>

                                <div style="position:relative;width:100%;height:320px;">
                                    <canvas id="st-score-radar-canvas"></canvas>
                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Submitted Documents Overview -->
                    <div class="card">

                        <div class="card-header">

                            <h3 class="card-title">
                                Verification Documents Status
                            </h3>

                            <a href="<?= base_url('documents') ?>"
                               class="btn btn-secondary btn-sm">
                                + Upload Document
                            </a>

                        </div>

                        <div class="table-responsive">

                            <table class="custom-table">

                                <thead>
                                    <tr>
                                        <th>Document Name</th>
                                        <th>Submitted Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody id="st-docs-table-body">

                                    <?php if (!empty($documents)): ?>

                                        <?php foreach ($documents as $document): ?>

                                            <tr>

                                                <td>
                                                    <?= esc($document['document_name'] ?? 'Document') ?>
                                                </td>

                                                <td>

                                                    <?php
                                                    $submittedDate =
                                                        $document['uploaded_at']
                                                        ?? $document['created_at']
                                                        ?? null;
                                                    ?>

                                                    <?= $submittedDate
                                                        ? esc(date('d M Y', strtotime($submittedDate)))
                                                        : '—' ?>

                                                </td>

                                                <td>

                                                    <span class="badge badge-new">
                                                        <?= esc($document['status'] ?? 'Pending') ?>
                                                    </span>

                                                </td>

                                                <td>

                                                    <?php if (!empty($document['file_path'])): ?>

                                                        <a href="<?= base_url($document['file_path']) ?>"
                                                           class="btn btn-secondary btn-sm"
                                                           target="_blank"
                                                           rel="noopener noreferrer">
                                                            View
                                                        </a>

                                                    <?php else: ?>

                                                        <span>—</span>

                                                    <?php endif; ?>

                                                </td>

                                            </tr>

                                        <?php endforeach; ?>

                                    <?php else: ?>

                                        <tr>
                                            <td colspan="4" style="text-align:center;">
                                                No documents uploaded yet.
                                            </td>
                                        </tr>

                                    <?php endif; ?>

                                </tbody>

                            </table>

                        </div>

                        <?php if (empty($documents)): ?>

                            <div class="empty-state" id="st-docs-empty">

                                <div class="empty-state-icon">📄</div>

                                <h3>No Documents Uploaded Yet</h3>

                                <p>
                                    Go to Document Manager to upload required verification documents.
                                </p>

                            </div>

                        <?php endif; ?>

                    </div>

                </section>

            </main>

        </div>

    </div>

    <!-- Dashboard JavaScript -->
    <script>

        // Animate only numeric metric values.
        function animateCount(el, target, duration = 1200) {

            let startTime = null;

            function update(currentTime) {

                if (!startTime) {
                    startTime = currentTime;
                }

                const progress = Math.min(
                    (currentTime - startTime) / duration,
                    1
                );

                el.textContent = Math.floor(progress * target);

                if (progress < 1) {
                    requestAnimationFrame(update);
                } else {
                    el.textContent = target;
                }

            }

            requestAnimationFrame(update);

        }


        // Animate percentage metrics only.
        document.querySelectorAll('.metric-val').forEach(function (el) {

            const originalText = el.textContent.trim();

            if (/^\d+%$/.test(originalText)) {

                const target = parseInt(originalText, 10);

                animateCount(el, target);

                el.textContent = '0%';

            }

        });


        // Sidebar Toggle
        document.getElementById('sidebar-toggle')
            ?.addEventListener('click', function () {

                document.querySelector('.sidebar')
                    ?.classList.toggle('collapsed');

                this.classList.toggle('active');

                this.style.transform = 'scale(0.85)';

                setTimeout(() => {
                    this.style.transform = 'scale(1)';
                }, 150);

            });


        // Logout
        document.getElementById('btn-logout')
            ?.addEventListener('click', async function () {

                try {

                    await fetch('<?= base_url('api/logout') ?>', {
                        method: 'POST',
                        credentials: 'same-origin'
                    });

                } catch (error) {

                    console.error('Logout request failed:', error);

                }

                window.location.href = '<?= base_url('login') ?>';

            });


        // Certificate Card
        function showCertificate(verId) {

            if (!verId) {
                return;
            }

            document.getElementById('cert-ver-id').textContent = verId;

            document.getElementById('cert-qr-text').textContent = verId;

            document.getElementById('certificate-card').style.display = 'block';

        }


        // Verified Directory
        function renderDirectory() {

            const searchInput = document.getElementById('dir-search');
            const industrySelect = document.getElementById('dir-industry');
            const directoryBody = document.getElementById('dir-body');
            const emptyMessage = document.getElementById('dir-empty');

            if (!searchInput || !industrySelect || !directoryBody || !emptyMessage) {
                return;
            }

            // Real verified-company API will be connected here.
            directoryBody.innerHTML = '';

            emptyMessage.style.display = 'block';

        }


        document.getElementById('dir-search')
            ?.addEventListener('input', renderDirectory);

        document.getElementById('dir-industry')
            ?.addEventListener('change', renderDirectory);


        // Initialize Directory
        renderDirectory();

    </script>

</body>

</html>