<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ICTRD Tech Due-Diligence & Trust Score Platform</title>
  <meta name="description" content="ICTRD Tech Due-Diligence & Trust Score Platform — Register, submit company profiles, upload documents, and receive ICTRD-verified assessment certification with QR-based verification.">
  
  <!-- Modern Font Stack -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  
  <!-- Design System & Styles -->
  <link rel="stylesheet" href="css/style.css">
</head>
<body>

  <!-- =============================================
       AUTHENTICATION SCREEN (Registration / Login)
       ============================================= -->
  <div class="auth-screen" id="auth-screen">
    <div class="auth-container">
      
      <!-- Brand -->
      <div class="auth-brand">
        <div class="auth-brand-badge">ICTRD</div>
        <h1>Tech Due-Diligence & Trust Score</h1>
        <p>Verification & Assessment Platform</p>
      </div>

      <!-- Auth Card -->
      <div class="auth-card">
        
        <!-- Tabs -->
        <div class="auth-tabs">
          <button class="auth-tab-btn active" data-tab="register" id="tab-register-btn">Register</button>
          <button class="auth-tab-btn" data-tab="login" id="tab-login-btn">Login</button>
        </div>

        <!-- Error Display -->
        <div class="auth-error" id="auth-error"></div>

        <!-- Registration Panel -->
        <div class="auth-panel active" id="panel-register">
          <form class="auth-form" id="register-form">
            <div class="form-group">
              <label class="form-label">Company / Startup Name <span class="req">*</span></label>
              <input type="text" class="form-control" name="companyName" id="reg-company-name" placeholder="e.g. ABC Technologies Pvt. Ltd." required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Founder Name <span class="req">*</span></label>
                <input type="text" class="form-control" name="founderName" id="reg-founder-name" placeholder="e.g. Vikram Seth" required>
              </div>
              <div class="form-group">
                <label class="form-label">Contact Phone</label>
                <input type="tel" class="form-control" name="contactPhone" id="reg-phone" placeholder="+91 98765 43210">
              </div>
            </div>

            <div class="form-group">
              <label class="form-label">Email Address <span class="req">*</span></label>
              <input type="email" class="form-control" name="email" id="reg-email" placeholder="you@company.com" required>
            </div>

            <div class="form-row">
              <div class="form-group">
                <label class="form-label">Password <span class="req">*</span></label>
                <input type="password" class="form-control" name="password" id="reg-password" placeholder="Min 6 characters" required minlength="6">
              </div>
              <div class="form-group">
                <label class="form-label">Confirm Password <span class="req">*</span></label>
                <input type="password" class="form-control" name="confirmPassword" id="reg-confirm-password" placeholder="Re-enter password" required>
              </div>
            </div>

            <button type="submit" class="auth-submit-btn" id="btn-register">
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
              Create Account & Register
            </button>
          </form>

          <div class="auth-divider">or quick start</div>

          <button class="auth-demo-btn" id="btn-demo-mode">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Load Demo Mode (Pre-filled Data)
          </button>
        </div>

        <!-- Login Panel -->
        <div class="auth-panel" id="panel-login">
          <form class="auth-form" id="login-form">
            <div class="form-group">
              <label class="form-label">Email Address</label>
              <input type="email" class="form-control" name="email" id="login-email" placeholder="you@company.com" required>
            </div>
            <div class="form-group">
              <label class="form-label">Password</label>
              <input type="password" class="form-control" name="password" id="login-password" placeholder="Enter password" required>
            </div>

            <button type="submit" class="auth-submit-btn" id="btn-login">
              <svg width="18" height="18" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
              Sign In
            </button>
          </form>

          <div class="auth-divider">or quick start</div>

          <button class="auth-demo-btn" id="btn-demo-mode-login">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Load Demo Mode (Pre-filled Data)
          </button>
        </div>

      </div>
    </div>
  </div>


  <!-- =============================================
       MAIN APPLICATION WRAPPER (hidden until login)
       ============================================= -->
  <div class="app-wrapper" id="app-wrapper">

    <!-- Header & Top Navigation Bar -->
    <header class="navbar">
      <a href="#" class="brand-logo">
        <div class="brand-badge">ICTRD</div>
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

        <!-- Persona Switcher -->
        <div class="role-switcher">
          <button class="role-btn active" data-role="startup">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            Startup
          </button>
          <button class="role-btn" data-role="evaluator">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Evaluator
          </button>
          <button class="role-btn" data-role="admin">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
            Admin
          </button>
          <button class="role-btn" data-role="public">
            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Public Verification
          </button>
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
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            Dashboard & Status
          </a>
          <a class="nav-link" data-view="startup-profile" id="nav-link-profile">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            Company Profile
          </a>
          <a class="nav-link" data-view="startup-docs" id="nav-link-docs">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Document Manager
          </a>
          <a class="nav-link" data-view="startup-apply" id="nav-link-apply">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            Assessment Application
          </a>
        </div>

        <!-- ADMIN LINKS -->
        <div class="role-nav role-admin" style="display:none;">
          <div class="sidebar-title">ICTRD Admin</div>
          <a class="nav-link" data-view="admin-dashboard">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            Applications Overview
          </a>
          <a class="nav-link" data-view="admin-params">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
            Assessment Parameters
          </a>
        </div>

        <!-- EVALUATOR LINKS -->
        <div class="role-nav role-evaluator" style="display:none;">
          <div class="sidebar-title">Evaluator Workspace</div>
          <a class="nav-link" data-view="eval-dashboard">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
            Assigned Queue
          </a>
        </div>

        <!-- PUBLIC LINKS -->
        <div class="role-nav role-public" style="display:none;">
          <div class="sidebar-title">Public Portal</div>
          <a class="nav-link" data-view="public-search">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            Verify Verification ID
          </a>
          <a class="nav-link" data-view="public-directory">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
            Verified Directory
          </a>
        </div>

        <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--light-border);">
          <button class="btn btn-secondary btn-sm" style="width:100%;" onclick="AppStore.resetDB()">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
            Reset All Data
          </button>
        </div>

      </aside>

      <!-- Main Dynamic Content Views -->
      <main class="main-content">

        <!-- ==================== 1. STARTUP DASHBOARD ==================== -->
        <section id="startup-dashboard" class="view-section active">
          <div class="page-header">
            <div style="display:flex; justify-content:space-between; align-items:center;">
              <div>
                <h1 class="page-title" id="st-comp-name">My Company</h1>
                <p class="page-desc">ICTRD Assessment Portal & Application Status Tracker</p>
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
                <div class="step-8-label">ICTRD Review</div>
              </div>
              <div class="wizard-step-8 locked" data-step="8">
                <div class="step-8-circle">8</div>
                <div class="step-8-label">Certification & QR</div>
              </div>
            </div>
          </div>

          <!-- Verification Summary Card (If verified — step 8 complete) -->
          <div class="card" id="st-cert-summary-card" style="border: 2px solid var(--primary); display: none;">
            <div class="card-header">
              <h3 class="card-title" style="color:var(--primary);">
                <svg width="22" height="22" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                ICTRD Assessment Result & Verification Active
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
              <a href="#" class="btn btn-secondary btn-sm" onclick="switchView('startup-docs')">+ Upload Document</a>
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

        <!-- ==================== 2. STARTUP PROFILE FORM ==================== -->
        <section id="startup-profile" class="view-section">
          <div class="page-header">
            <h1 class="page-title">Company & Tech Profile</h1>
            <p class="page-desc">Complete your business, technology, and IP details for ICTRD Due-Diligence evaluation</p>
          </div>

          <!-- Step completion banner (shown after profile is saved) -->
          <div class="step-complete-banner" id="profile-complete-banner" style="display:none;">
            <div class="icon">✅</div>
            <div>
              <div class="text">Profile Complete!</div>
              <div class="sub">You can now proceed to Document Upload (Step 3)</div>
            </div>
          </div>

          <form id="startup-profile-form">
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

        <!-- ==================== 3. DOCUMENT MANAGER ==================== -->
        <section id="startup-docs" class="view-section">
          <div class="page-header">
            <h1 class="page-title">Document Manager</h1>
            <p class="page-desc">Upload required verification documents for ICTRD assessment</p>
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
            <form id="doc-upload-form">
              <div class="form-row">
                <div class="form-group">
                  <label class="form-label">Document Title <span class="req">*</span></label>
                  <input type="text" id="doc-name-input" class="form-control" placeholder="e.g. Audit Report FY25, Patent Spec" required>
                </div>
                <div class="form-group">
                  <label class="form-label">Document Category</label>
                  <select id="doc-type-select" class="form-select">
                    <option value="incorporation">Certificate of Incorporation</option>
                    <option value="tax">PAN / GST Certificate</option>
                    <option value="dpiit">DPIIT Certificate</option>
                    <option value="pitch">Pitch Deck</option>
                    <option value="financials">Financial Statements</option>
                    <option value="patent">Patent / IP Document</option>
                    <option value="other">Other</option>
                  </select>
                </div>
                <div class="form-group">
                  <label class="form-label">Select File</label>
                  <input type="file" class="form-control">
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

        <!-- ==================== 4. APPLY & PAYMENT ==================== -->
        <section id="startup-apply" class="view-section">
          <div class="page-header">
            <h1 class="page-title">Apply for ICTRD Assessment</h1>
            <p class="page-desc">Submit your company for official ICTRD Tech Due-Diligence & Verification Certification</p>
          </div>

          <!-- Already Applied Banner -->
          <div class="step-complete-banner" id="apply-complete-banner" style="display:none;">
            <div class="icon">✅</div>
            <div>
              <div class="text">Application Submitted & Payment Complete!</div>
              <div class="sub">Your application is now under ICTRD review. An evaluator will be assigned shortly.</div>
            </div>
          </div>

          <div class="card" id="apply-card">
            <div class="card-header">
              <h3 class="card-title">Assessment Application Tier</h3>
            </div>
            <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--radius-md); padding:1.25rem; margin-bottom:1.5rem;">
              <h4 style="font-family:'Outfit',sans-serif; font-size:1.3rem; color:var(--primary); margin-bottom:4px;">Full ICTRD Tech Due-Diligence & Trust Score Assessment</h4>
              <p style="font-size:0.92rem; color:#334155;">Includes 9-parameter expert evaluator assessment, dynamic score report, unique Verification ID issuance, QR code digital badge, and listing in the public ICTRD Verified Directory.</p>
              <div style="margin-top:12px; font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#0f172a;">
                Assessment Fee: ₹4,999 <small style="font-size:0.85rem; color:#64748b; font-weight:normal;">+ GST</small>
              </div>
            </div>

            <button id="btn-trigger-payment" class="btn btn-primary">Proceed to Payment & Submit Application</button>
          </div>
        </section>

        <!-- ==================== 5. ADMIN DASHBOARD ==================== -->
        <section id="admin-dashboard" class="view-section">
          <div class="page-header">
            <h1 class="page-title">ICTRD Admin Dashboard</h1>
            <p class="page-desc">Manage startup assessment applications, evaluator assignments, and certificates</p>
          </div>

          <!-- Metrics -->
          <div class="metrics-grid">
            <div class="metric-card">
              <div class="metric-icon">📋</div>
              <div>
                <div class="metric-val" id="adm-total-apps">0</div>
                <div class="metric-label">Total Applications</div>
              </div>
            </div>
            <div class="metric-card">
              <div class="metric-icon">⏳</div>
              <div>
                <div class="metric-val" id="adm-under-review">0</div>
                <div class="metric-label">Under Review</div>
              </div>
            </div>
            <div class="metric-card">
              <div class="metric-icon">🛡️</div>
              <div>
                <div class="metric-val" id="adm-active-verifications">0</div>
                <div class="metric-label">Active Verifications</div>
              </div>
            </div>
            <div class="metric-card">
              <div class="metric-icon">💰</div>
              <div>
                <div class="metric-val" id="adm-total-revenue">₹0</div>
                <div class="metric-label">Assessment Revenue</div>
              </div>
            </div>
          </div>

          <!-- Applications Pipeline Table -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Applications Pipeline</h3>
            </div>
            <div class="table-responsive">
              <table class="custom-table">
                <thead>
                  <tr>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Assigned Evaluator</th>
                    <th>Overall Score</th>
                    <th>Verification ID</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody id="adm-apps-table-body">
                  <!-- Dynamic insertion -->
                </tbody>
              </table>
            </div>
            <div class="empty-state" id="adm-empty-state" style="display:none;">
              <div class="empty-state-icon">📭</div>
              <h3>No Applications Yet</h3>
              <p>Applications will appear here when startups submit their assessment requests.</p>
            </div>
          </div>
        </section>

        <!-- ==================== 6. ADMIN PARAMS ==================== -->
        <section id="admin-params" class="view-section">
          <div class="page-header">
            <h1 class="page-title">Assessment Parameter & Weight Configurator</h1>
            <p class="page-desc">Define and configure weightage for ICTRD Tech Due-Diligence evaluation parameters</p>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Configured Parameters (Total Weight: <span id="adm-total-weight-val" style="color:var(--primary);">100%</span>)</h3>
              <button class="btn btn-primary btn-sm" id="btn-save-params">Save Parameter Weightages</button>
            </div>
            <div class="table-responsive">
              <table class="custom-table">
                <thead>
                  <tr>
                    <th>Parameter Name</th>
                    <th>Description</th>
                    <th>Weightage (%)</th>
                  </tr>
                </thead>
                <tbody id="adm-params-table-body">
                  <!-- Dynamic parameters -->
                </tbody>
              </table>
            </div>
          </div>
        </section>

        <!-- ==================== 7. EVALUATOR DASHBOARD ==================== -->
        <section id="eval-dashboard" class="view-section">
          <div class="page-header">
            <h1 class="page-title">Evaluator Workspace</h1>
            <p class="page-desc">Review assigned applications, perform technology due-diligence, and enter parameter scores</p>
          </div>

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Assigned Applications Queue</h3>
            </div>
            <div class="table-responsive">
              <table class="custom-table">
                <thead>
                  <tr>
                    <th>Company</th>
                    <th>Status</th>
                    <th>Industry</th>
                    <th>Score Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="eval-apps-table-body">
                  <!-- Dynamic queue -->
                </tbody>
              </table>
            </div>
            <div class="empty-state" id="eval-empty-state" style="display:none;">
              <div class="empty-state-icon">📝</div>
              <h3>No Assigned Applications</h3>
              <p>Applications will appear here when the admin assigns them to an evaluator.</p>
            </div>
          </div>
        </section>

        <!-- ==================== 8. PUBLIC SEARCH ==================== -->
        <section id="public-search" class="view-section">
          <div class="page-header">
            <h1 class="page-title">ICTRD Public Verification</h1>
            <p class="page-desc">Verify authenticity of ICTRD Assessment Certificates and Verification IDs</p>
          </div>

          <div class="card" style="text-align:center; padding:2.5rem 1.5rem;">
            <h2 style="font-family:'Outfit',sans-serif; font-size:1.6rem; margin-bottom:1rem;">Enter ICTRD Verification ID</h2>
            <div style="max-width:550px; margin:0 auto; display:flex; gap:10px;">
              <input type="text" id="public-search-input" class="form-control" placeholder="e.g. ICTRD-TD-2026-00125 or company name">
              <button class="btn btn-primary" id="btn-public-search">Verify Now</button>
            </div>
          </div>

          <!-- Result Card -->
          <div id="public-result-card" style="display:none;">
            <div class="certificate-frame">
              <div class="cert-header">
                <div class="cert-ictrd-logo">ICTRD</div>
                <div class="cert-subtitle">Official Tech Due-Diligence & Verification Certificate</div>
              </div>

              <div class="cert-body">
                <p style="font-size:1rem; color:#475569;">This is to certify that</p>
                <div class="cert-company-name" id="pub-cert-comp-name">--</div>
                <p id="pub-cert-industry" style="color:#64748b; font-weight:500;">--</p>

                <p style="margin-top:1.25rem; color:#334155;">has successfully undergone ICTRD Technology & Business Model Assessment</p>
                <div class="cert-score-pill">Assessment Score: <span id="pub-cert-score">--</span></div>
              </div>

              <div class="cert-footer">
                <div style="text-align:left;">
                  <strong>Verification ID:</strong> <code id="pub-cert-ver-id">--</code><br>
                  <strong>Status:</strong> <span class="badge badge-active" id="pub-cert-status-badge">Active</span><br>
                  <span id="pub-cert-valid-until" style="font-size:0.85rem; color:#64748b;">--</span>
                </div>
                <div id="pub-cert-qr-box"></div>
              </div>
            </div>

            <!-- Parameter breakdown under public search -->
            <div class="card" style="margin-top:2rem;">
              <div class="card-header">
                <h3 class="card-title">Public Assessment Score Breakdown</h3>
                <button class="btn btn-secondary btn-sm" onclick="AppStore.exportPDFReport()">Export Official PDF Report</button>
              </div>

              <div style="display:grid; grid-template-columns: 1fr 1fr; gap:2rem;">
                <div id="pub-cert-bar-breakdown"></div>
                <div>
                  <canvas id="pub-cert-radar-canvas"></canvas>
                </div>
              </div>
            </div>
          </div>

          <!-- Not Found -->
          <div id="public-notfound-card" class="card" style="display:none; text-align:center; padding:2rem;">
            <h3 style="color:var(--danger);">No Active ICTRD Verification Found</h3>
            <p style="color:#64748b;">The requested Verification ID was not found or has been revoked.</p>
          </div>
        </section>

        <!-- ==================== 9. PUBLIC DIRECTORY ==================== -->
        <section id="public-directory" class="view-section">
          <div class="page-header">
            <h1 class="page-title">ICTRD Verified Company Directory</h1>
            <p class="page-desc">Discover and verify technology companies assessed and certified by ICTRD</p>
          </div>

          <div class="filter-bar">
            <input type="text" id="dir-search-input" class="form-control" placeholder="Search by Company or Tech Stack...">
            <select id="dir-industry-select" class="form-select">
              <option value="">All Industries</option>
              <option value="DeepTech">DeepTech / AI</option>
              <option value="CleanTech">CleanTech</option>
              <option value="HealthTech">HealthTech</option>
              <option value="FinTech">FinTech</option>
              <option value="AgriTech">AgriTech</option>
            </select>
            <select id="dir-score-select" class="form-select">
              <option value="0">All Score Ranges</option>
              <option value="85">Score > 85/100</option>
              <option value="80">Score > 80/100</option>
            </select>
          </div>

          <div class="card">
            <div class="table-responsive">
              <table class="custom-table">
                <thead>
                  <tr>
                    <th>Company Name</th>
                    <th>Industry</th>
                    <th>Score</th>
                    <th>Verification ID</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody id="dir-table-body">
                  <!-- Dynamic insertion -->
                </tbody>
              </table>
            </div>
            <div class="empty-state" id="dir-empty-state" style="display:none;">
              <div class="empty-state-icon">🔍</div>
              <h3>No Verified Companies Found</h3>
              <p>Verified companies will appear here once ICTRD certifies them.</p>
            </div>
          </div>
        </section>

      </main>
    </div>
  </div>

  <!-- MODALS -->

  <!-- Razorpay Payment Modal -->
  <div class="modal-backdrop" id="razorpay-modal">
    <div class="modal-box" style="max-width:450px;">
      <div class="modal-header">
        <h3 class="card-title">Razorpay Payment Sandbox</h3>
        <button class="modal-close" onclick="AppStore.closeModals()">&times;</button>
      </div>
      <div style="text-align:center; padding:1rem 0;">
        <div style="font-size:1rem; font-weight:700; color:#334155;">ICTRD Tech Assessment Fee</div>
        <div style="font-family:'Outfit',sans-serif; font-size:2.2rem; font-weight:800; color:var(--primary); margin:8px 0;">₹4,999.00</div>
        <p style="font-size:0.85rem; color:#64748b; margin-bottom:1.5rem;">Simulated Razorpay Gateway Integration</p>
        <button class="btn btn-primary" id="btn-confirm-razorpay" style="width:100%;">Complete Test Payment</button>
      </div>
    </div>
  </div>

  <!-- Admin Assign Evaluator Modal -->
  <div class="modal-backdrop" id="assign-modal">
    <div class="modal-box">
      <div class="modal-header">
        <h3 class="card-title">Assign Evaluator to <span id="assign-comp-title"></span></h3>
        <button class="modal-close" onclick="AppStore.closeModals()">&times;</button>
      </div>
      <input type="hidden" id="assign-startup-id">
      <div class="form-group">
        <label class="form-label">Select Qualified ICTRD Evaluator</label>
        <select id="assign-evaluator-select" class="form-select"></select>
      </div>
      <div style="display:flex; justify-content:flex-end; gap:10px;">
        <button class="btn btn-secondary" onclick="AppStore.closeModals()">Cancel</button>
        <button class="btn btn-primary" id="btn-confirm-assign">Assign & Notify Evaluator</button>
      </div>
    </div>
  </div>

  <!-- Admin Issue Certificate Modal -->
  <div class="modal-backdrop" id="issue-modal">
    <div class="modal-box">
      <div class="modal-header">
        <h3 class="card-title">Issue Verification Certificate: <span id="issue-comp-title"></span></h3>
        <button class="modal-close" onclick="AppStore.closeModals()">&times;</button>
      </div>
      <input type="hidden" id="issue-startup-id">
      <p style="margin-bottom:1rem;">
        <strong>Evaluator Score:</strong> <span id="issue-eval-score" class="text-primary"></span>
      </p>
      <div class="form-group">
        <label class="form-label">ICTRD Verification ID</label>
        <input type="text" id="issue-ver-id-input" class="form-control">
      </div>
      <div style="display:flex; justify-content:flex-end; gap:10px;">
        <button class="btn btn-secondary" onclick="AppStore.closeModals()">Cancel</button>
        <button class="btn btn-success" id="btn-confirm-issue-cert">Approve & Issue Certificate</button>
      </div>
    </div>
  </div>

  <!-- Evaluator Studio Modal -->
  <div class="modal-backdrop" id="eval-studio-modal">
    <div class="modal-box" style="max-width:850px;">
      <div class="modal-header">
        <div>
          <h3 class="card-title">Evaluation Studio: <span id="eval-studio-comp-title"></span></h3>
          <span class="badge badge-active" style="margin-top:4px;">Live Calculated Score: <span id="eval-live-score-badge">80/100</span></span>
        </div>
        <button class="modal-close" onclick="AppStore.closeModals()">&times;</button>
      </div>

      <form id="evaluation-form">
        <input type="hidden" id="eval-studio-startup-id">
        
        <!-- Dossier -->
        <div style="background:#f8fafc; padding:12px; border-radius:var(--radius-md); margin-bottom:1rem; border:1px solid #e2e8f0; font-size:0.88rem;">
          <strong>Description:</strong> <span id="eval-dossier-desc"></span><br>
          <strong>Tech Stack:</strong> <span id="eval-dossier-tech"></span><br>
          <strong>IP & Patents:</strong> <span id="eval-dossier-ip"></span>
        </div>

        <h4 style="margin-bottom:10px;">Parameter Scoring Sliders (Weighted 100%)</h4>
        <div id="eval-sliders-container" style="max-height:280px; overflow-y:auto; padding-right:8px; margin-bottom:1rem;">
          <!-- Dynamic Sliders -->
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Key Strengths</label>
            <textarea id="eval-strengths-input" class="form-control" placeholder="Observed technical strengths..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Areas of Improvement</label>
            <textarea id="eval-improvements-input" class="form-control" placeholder="Recommendations for improvement..."></textarea>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label class="form-label">Risk & Observations Matrix</label>
            <textarea id="eval-risks-input" class="form-control" placeholder="Identified technology or market risks..."></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Evaluator Final Remarks</label>
            <textarea id="eval-remarks-input" class="form-control" placeholder="Final auditor comments..."></textarea>
          </div>
        </div>

        <div style="display:flex; justify-content:flex-end; gap:10px;">
          <button type="button" class="btn btn-secondary" onclick="AppStore.closeModals()">Cancel</button>
          <button type="submit" class="btn btn-primary">Submit Final Evaluation</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Vendor JS Libraries -->
  <script src="js/qrcode.min.js"></script>
  <script src="js/chart-custom.js"></script>
  <script src="js/app.js"></script>
</body>
</html>
