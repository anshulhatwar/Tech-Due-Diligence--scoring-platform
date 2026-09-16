<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Company Profile — Credence</title>
  <meta name="description" content="Credence Tech Due-Diligence & Trust Score Platform — Company Profile">

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
          <a class="nav-link active" data-view="startup-profile" id="nav-link-profile" href="<?= base_url('profile') ?>">
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

        <section id="startup-profile" class="view-section active">
          <div class="page-header">
            <h1 class="page-title">Company & Tech Profile</h1>
            <p class="page-desc">Complete your business, technology, and IP details for Credence Due-Diligence evaluation</p>
          </div>

          <!-- Step completion banner (shown after profile is saved) -->
          <div class="step-complete-banner" id="profile-complete-banner" style="display:none;">
            <div class="icon">✅</div>
            <div>
              <div class="text">Profile Complete!</div>
              <div class="sub">You can now proceed to Document Upload (Step 3)</div>
            </div>
          </div>

          <form id="startup-profile-form" method="post" action="<?= base_url('profile/save') ?>">
            <!-- Basic Info -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">1. Basic Information</h3>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Company / Startup Name <span class="req">*</span></label>
                  <input type="text" name="companyName" class="form-control" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Founder Details <span class="req">*</span></label>
                  <input type="text" name="founderDetails" class="form-control" required>
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Contact Email <span class="req">*</span></label>
                  <input type="email" name="contactEmail" class="form-control" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Contact Phone</label>
                  <input type="text" name="contactPhone" class="form-control">
                </div>
                <div class="form-group">
                  <label class="form-label">Website</label>
                  <input type="url" name="website" class="form-control">
                </div>
              </div>

              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Location / City</label>
                  <input type="text" name="location" class="form-control">
                </div>
                <div class="form-group">
                  <label class="form-label">Industry / Sector <span class="req">*</span></label>
                  <select name="industry" class="form-select" required>
                    <option value="">Select Industry</option>
                    <option value="DeepTech / AI">DeepTech / AI</option>
                    <option value="CleanTech / Renewable Energy">CleanTech / Renewable Energy</option>
                    <option value="HealthTech / MedTech">HealthTech / MedTech</option>
                    <option value="FinTech">FinTech</option>
                    <option value="AgriTech">AgriTech</option>
                    <option value="EdTech">EdTech</option>
                    <option value="SaaS / Enterprise">SaaS / Enterprise</option>
                    <option value="Other">Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Year Established</label>
                  <input type="text" name="yearEstablished" class="form-control">
                </div>
                <div class="form-group">
                  <label class="form-label">Team Size</label>
                  <input type="number" name="teamSize" class="form-control">
                </div>
              </div>

              <div class="form-group">
                <label class="form-label">Company Description <span class="req">*</span></label>
                <textarea name="companyDescription" class="form-control" required placeholder="Brief description of what your company does..."></textarea>
              </div>
            </div>

            <!-- Business Info -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">2. Business Model & Market Potential</h3>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Problem Statement</label>
                  <textarea name="problemStatement" class="form-control" placeholder="What problem are you solving?"></textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Product / Service</label>
                  <textarea name="productService" class="form-control" placeholder="Describe your product or service"></textarea>
                </div>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Business & Revenue Model</label>
                  <textarea name="businessModel" class="form-control" placeholder="How do you make money?"></textarea>
                </div>
                <div class="form-group">
                  <label class="form-label">Unique Selling Proposition (USP)</label>
                  <textarea name="usp" class="form-control" placeholder="What makes you different?"></textarea>
                </div>
              </div>
            </div>

            <!-- Tech Info -->
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">3. Technology & IP Information</h3>
              </div>
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Technology Used & Stack <span class="req">*</span></label>
                  <input type="text" name="technologyUsed" class="form-control" required placeholder="e.g. Python, React, AWS, Kubernetes">
                </div>
                <div class="form-group">
                  <label class="form-label">Intellectual Property / Patents</label>
                  <input type="text" name="intellectualProperty" class="form-control" placeholder="e.g. 2 Granted Patents, 1 PCT Filing">
                </div>
              </div>
            </div>

            <div style="display:flex; justify-content:flex-end;">
              <button type="submit" class="btn btn-primary">Save Company Profile & Proceed →</button>
            </div>
          </form>
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