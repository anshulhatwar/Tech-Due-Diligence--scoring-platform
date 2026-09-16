<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Startup Dashboard — Credence</title>
  <meta name="description" content="Credence Tech Due-Diligence & Trust Score Platform — Startup Dashboard">

  <!-- Modern Font Stack -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

  <!-- Design System & Styles -->
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

  <div class="app-wrapper active" id="app-wrapper">

    <!-- Header & Top Navigation Bar -->
    <header class="navbar">
      <a href="#" class="brand-logo">
        <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:34px;">
        <div>
          <div class="brand-title">Tech Due-Diligence & Trust Score</div>
          <span class="brand-sub">Verification & Assessment Platform</span>
        </div>
      </a>

      <div class="nav-controls">
        <!-- User Info -->
        <div class="nav-user-info">
          <div class="nav-user-avatar" id="nav-user-avatar">VS</div>
          <span id="nav-user-name">Vikram Seth</span>
        </div>

        <button class="nav-logout-btn" id="btn-logout">Logout</button>
      </div>
    </header>

    <div class="app-container">
      <!-- Sidebar Navigation -->
      <aside class="sidebar">

        <!-- STARTUP LINKS -->
        <div class="role-nav role-startup">
          <div class="sidebar-title">Startup Portal</div>
          <a class="nav-link active" data-view="startup-dashboard">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard & Status
          </a>
          <a class="nav-link" data-view="startup-profile" id="nav-link-profile" href="<?= base_url('profile') ?>">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Company Profile
          </a>
          <a class="nav-link" data-view="startup-docs" id="nav-link-docs" href="<?= base_url('documents') ?>">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Document Manager
          </a>
          <a class="nav-link" data-view="startup-apply" id="nav-link-apply" href="<?= base_url('apply') ?>">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Assessment Application
          </a>
        </div>

        <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--light-border);">
          <button class="btn btn-secondary btn-sm" style="width:100%;" onclick="AppStore.resetDB()">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Reset All Data
          </button>
        </div>

      </aside>

      <!-- Main Dynamic Content -->
      <main class="main-content">

        <section id="startup-dashboard" class="view-section active">
          <div class="page-header">
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <div>
                <h1 class="page-title" id="st-comp-name">My Company</h1>
                <p class="page-desc">Credence Assessment Portal & Application Status Tracker</p>
              </div>
              <span class="badge badge-new" id="st-app-status-badge">Registered</span>
            </div>
          </div>

          <!-- 8-Step Wizard Progress -->
          <div class="workflow-wizard">
            <div class="workflow-wizard-title">Assessment Workflow Progress</div>
            <div class="wizard-steps-8" id="wizard-steps-8">
              <div class="wizard-progress-fill" id="wizard-progress-fill" style="width: 0%;"></div>
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

          <!-- Verification Summary Card (shown once step 8 is complete) -->
          <div class="card" id="st-cert-summary-card" style="border: 2px solid var(--primary); display: none;">
            <div class="card-header">
              <h3 class="card-title" style="color:var(--primary);">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                Assessment Result & Verification Active
              </h3>
              <div>
                <button class="btn btn-secondary btn-sm" onclick="AppStore.exportPDFReport()">Download PDF Report</button>
                <button class="btn btn-primary btn-sm" onclick="AppStore.viewPublicCert()" style="margin-left:6px;">View Public Badge</button>
              </div>
            </div>

            <div style="display:grid; grid-template-columns: 1fr 1fr; gap:2rem;">
              <div>
                <div style="font-size:0.9rem; color:#64748b; font-weight:600;">OVERALL ASSESSMENT SCORE</div>
                <div style="font-family:'Outfit',sans-serif; font-size:3.2rem; font-weight:800; color:var(--primary);" id="st-score-val">-- / 100</div>
                <p style="font-size:0.88rem; color:#334155; margin-bottom:12px;">
                  <strong>Verification ID:</strong> <code id="st-ver-id-val">--</code><br>
                  <span id="st-ver-valid-val">--</span>
                </p>

                <div style="margin-top:1.5rem;">
                  <h4 style="font-size:0.95rem; font-weight:700; margin-bottom:8px;">Parameter Breakdown</h4>
                  <div id="st-score-breakdown-bars"></div>
                </div>
              </div>

              <div>
                <h4 style="font-size:0.95rem; font-weight:700; margin-bottom:8px; text-align:center;">Radar Assessment Matrix</h4>
                <div style="position:relative; width:100%; height:320px;">
                  <canvas id="st-score-radar-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Submitted Documents Overview -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Verification Documents Status</h3>
              <a href="<?= base_url('documents') ?>" class="btn btn-secondary btn-sm">+ Upload Document</a>
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
                  <!-- Dynamic insertion -->
                </tbody>
              </table>
            </div>
            <div class="empty-state" id="st-docs-empty" style="display:none;">
              <div class="empty-state-icon">📄</div>
              <h3>No Documents Uploaded Yet</h3>
              <p>Go to Document Manager to upload required verification documents.</p>
            </div>
          </div>
        </section>

      </main>
    </div>
  </div>

  <!-- Vendor JS Libraries -->
  <script src="<?= base_url('js/qrcode.min.js') ?>"></script>
  <script src="<?= base_url('js/chart-custom.js') ?>"></script>
  <script src="<?= base_url('js/app.js') ?>"></script>
</body>
</html>