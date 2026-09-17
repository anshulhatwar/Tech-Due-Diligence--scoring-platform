<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document Manager — Credence</title>
  <meta name="description" content="Credence Tech Due-Diligence & Trust Score Platform — Document Manager">

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
      <a href="<?= base_url('dashboard') ?>" class="brand-logo">
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
          <a class="nav-link" data-view="startup-dashboard" href="<?= base_url('dashboard') ?>">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard & Status
          </a>
          <a class="nav-link" data-view="startup-profile" id="nav-link-profile" href="<?= base_url('profile') ?>">
            <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Company Profile
          </a>
          <a class="nav-link active" data-view="startup-docs" id="nav-link-docs" href="<?= base_url('documents') ?>">
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

        <section id="startup-docs" class="view-section active">
          <div class="page-header">
            <h1 class="page-title">Document Manager</h1>
            <p class="page-desc">Upload required verification documents for Credence assessment</p>
          </div>

          <div class="step-complete-banner" id="docs-complete-banner" style="display:none;">
            <div class="icon">✅</div>
            <div>
              <div class="text">Documents Uploaded!</div>
              <div class="sub">Minimum 3 documents uploaded. You can now Apply for Assessment (Step 4)</div>
            </div>
          </div>

          <div class="card" id="docs-upload-card">
            <div class="card-header">
              <h3 class="card-title">Upload New Supporting Document</h3>
            </div>
            <form id="doc-upload-form" method="post" action="<?= base_url('documents/upload') ?>" enctype="multipart/form-data">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Document Title <span class="req">*</span></label>
                  <input type="text" name="docName" id="doc-name-input" class="form-control" placeholder="e.g. Audit Report FY25, Patent Spec" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Document Category</label>
                  <select name="docType" id="doc-type-select" class="form-select">
                    <option value="incorporation">Certificate of Incorporation</option>
                    <option value="tax">PAN / GST Certificate</option>
                    <option value="dpiit">DPIIT Certificate</option>
                    <option value="pitch">Pitch Deck</option>
                    <option value="financials">Financial Statements</option>
                    <option value="patent">Patent / IP Document</option>
                    <option value="tech-arch">Technology Architecture Doc</option>
                    <option value="team">Team Resume / CVs</option>
                    <option value="compliance">Compliance Certificate</option>
                    <option value="other">Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Select File</label>
                  <input type="file" name="docFile" class="form-control">
                </div>
              </div>
              <button type="submit" class="btn btn-primary">Upload Document</button>
            </form>
          </div>

          <!-- Uploaded Documents List -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Uploaded Documents (<span id="docs-count">0</span>)</h3>
            </div>
            <div id="docs-list-container">
              <!-- Dynamic document cards -->
            </div>
            <div class="empty-state" id="docs-empty-state">
              <div class="empty-state-icon">📁</div>
              <h3>No Documents Yet</h3>
              <p>Upload at least 3 documents to proceed to Assessment Application.</p>
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