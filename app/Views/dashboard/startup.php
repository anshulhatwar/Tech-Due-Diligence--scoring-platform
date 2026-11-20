<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Startup Dashboard — Credence</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>

<header class="navbar">
  <button id="sidebar-toggle" class="hamburger-btn">
    <span class="bar bar1"></span>
    <span class="bar bar2"></span>
    <span class="bar bar3"></span>
  </button>
  <a href="<?= base_url('dashboard') ?>" class="brand-logo">
    <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:34px;">
    <div>
      <div class="brand-title">Tech Due-Diligence & Trust Score</div>
      <span class="brand-sub">Verification & Assessment Platform</span>
    </div>
  </a>
  <div class="nav-controls">
    <div class="nav-user-info">
      <div class="nav-user-avatar"><?= esc($userInitials ?? 'U') ?></div>
      <span><?= esc($userName ?? 'User') ?></span>
    </div>
    <button class="nav-logout-btn" id="btn-logout">Logout</button>
  </div>
</header>

<div class="app-container">
  <aside class="sidebar">
    <div class="role-nav role-startup">
      <div class="sidebar-title">Startup Portal</div>

      <a class="nav-link active" href="<?= base_url('dashboard') ?>">Dashboard & Status</a>
      <a class="nav-link" href="<?= base_url('profile') ?>">Company Profile</a>
      <a class="nav-link" href="<?= base_url('documents') ?>">Document Manager</a>
      <a class="nav-link" href="<?= base_url('apply') ?>">Assessment Application</a>

      <a class="nav-link locked" data-step="5" href="javascript:void(0)">
        <span>5. Evaluator Assignment</span>
        <small class="nav-sub" id="side-st5">Locked</small>
      </a>
      <a class="nav-link locked" data-step="6" href="javascript:void(0)">
        <span>6. Evaluation & Scoring</span>
        <small class="nav-sub" id="side-st6">Locked</small>
      </a>
      <a class="nav-link locked" data-step="7" href="javascript:void(0)">
        <span>7. Credence Review</span>
        <small class="nav-sub" id="side-st7">Locked</small>
      </a>
      <a class="nav-link locked" data-step="8" href="javascript:void(0)">
        <span>8. Certification & QR</span>
        <small class="nav-sub" id="side-st8">Locked</small>
      </a>
    </div>
  </aside>

  <main class="main-content">
    <div class="page-header">
      <div style="display:flex; justify-content:space-between; align-items:center;">
        <div>
          <h1 class="page-title" id="st-comp-name">My Company</h1>
          <p class="page-desc">Credence Assessment Portal & Application Status Tracker</p>
        </div>
        <span class="badge badge-new" id="st-app-status-badge">Registered</span>
      </div>
    </div>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-icon">📊</div>
        <div><div class="metric-val">25%</div><div class="metric-label">Profile Completion</div></div>
      </div>
      <div class="metric-card">
        <div class="metric-icon">📄</div>
        <div><div class="metric-val">0/3</div><div class="metric-label">Documents Uploaded</div></div>
      </div>
      <div class="metric-card">
        <div class="metric-icon">⏱️</div>
        <div><div class="metric-val">Step 2/8</div><div class="metric-label">Workflow Stage</div></div>
      </div>
      <div class="metric-card">
        <div class="metric-icon">🛡️</div>
        <div><div class="metric-val">Pending</div><div class="metric-label">Verification Status</div></div>
      </div>
    </div>

    <!-- 8-Step Wizard Progress -->
    <div class="workflow-wizard">
      <div class="workflow-wizard-title">Assessment Workflow Progress</div>
      <div class="wizard-steps-8" id="wizard-steps-8">
        <div class="wizard-progress-fill" id="wizard-progress-fill" style="width: 0%;"></div>
        <div class="wizard-step-8 completed" data-step="1"><div class="step-8-circle">✓</div><div class="step-8-label">Registration</div></div>
        <div class="wizard-step-8 active" data-step="2"><div class="step-8-circle">2</div><div class="step-8-label">Company Profile</div></div>
        <div class="wizard-step-8 locked" data-step="3"><div class="step-8-circle">3</div><div class="step-8-label">Documents</div></div>
        <div class="wizard-step-8 locked" data-step="4"><div class="step-8-circle">4</div><div class="step-8-label">Assessment Application</div></div>
        <div class="wizard-step-8 locked" data-step="5"><div class="step-8-circle">5</div><div class="step-8-label">Evaluator Assignment</div></div>
        <div class="wizard-step-8 locked" data-step="6"><div class="step-8-circle">6</div><div class="step-8-label">Evaluation & Scoring</div></div>
        <div class="wizard-step-8 locked" data-step="7"><div class="step-8-circle">7</div><div class="step-8-label">Credence Review</div></div>
        <div class="wizard-step-8 locked" data-step="8"><div class="step-8-circle">8</div><div class="step-8-label">Certification & QR</div></div>
      </div>
    </div>

    <!-- Evaluation Status -->
    <div class="card" id="evaluation-status-card">
      <div class="card-header">
        <h3 class="card-title">Evaluation Status</h3>
        <span class="badge badge-new" id="eval-status-badge">Not Started</span>
      </div>
      <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:1rem;">
        <div><div style="font-size:0.8rem; color:#64748b; font-weight:600;">APPLICATION</div><div style="font-weight:700;" id="eval-app-status">Not Submitted</div></div>
        <div><div style="font-size:0.8rem; color:#64748b; font-weight:600;">EVALUATOR</div><div style="font-weight:700;" id="eval-evaluator">Not Assigned</div></div>
        <div><div style="font-size:0.8rem; color:#64748b; font-weight:600;">EVALUATION</div><div style="font-weight:700;" id="eval-scoring">Pending</div></div>
        <div><div style="font-size:0.8rem; color:#64748b; font-weight:600;">FINAL SCORE</div><div style="font-weight:700; color:var(--primary);" id="eval-final-score">-- / 100</div></div>
      </div>
    </div>

    <!-- Certificate Card -->
    <div class="card" id="certificate-card" style="display:none; border:2px solid var(--primary);">
      <div class="card-header">
        <h3 class="card-title" style="color:var(--primary);">Certificate Issued</h3>
        <a id="cert-download-btn" class="btn btn-primary btn-sm" href="#" style="display:none;">Download PDF</a>
        <span class="badge badge-active">Active</span>
      </div>
      <div style="display:inline-block; padding:6px 14px; border:2px solid var(--primary); color:var(--primary); border-radius:999px; font-weight:800; font-size:0.8rem; margin-bottom:10px;">✓ Approved by CREDENCE</div>
      <div style="display:grid; grid-template-columns: 1fr auto; gap:2rem; align-items:center;">
        <div>
          <div style="font-size:0.8rem; color:#64748b; font-weight:600;">VERIFICATION ID</div>
          <div style="font-family:monospace; font-size:1.4rem; font-weight:700; color:var(--primary);" id="cert-ver-id">--</div>
          <div style="font-size:0.8rem; color:#64748b; font-weight:600; margin-top:10px;">TRUST SCORE</div>
          <div style="font-size:1.8rem; font-weight:800; color:var(--primary);" id="cert-score">-- / 100</div>
        </div>
        <div style="padding:12px; background:#fff; border:2px solid var(--primary); border-radius:8px; text-align:center;">
          <div id="cert-qr-canvas"></div>
          <div style="font-weight:700; font-family:monospace; font-size:0.85rem; margin-top:6px;" id="cert-qr-text">--</div>
        </div>
      </div>
    </div>

    <!-- Verified Directory -->
    <div class="card" id="directory-card">
      <div class="card-header">
        <h3 class="card-title">Verified Directory</h3>
        <span class="badge badge-active">Public</span>
      </div>
      <div style="display:flex; gap:10px; flex-wrap:wrap; margin-bottom:1rem;">
        <input type="text" id="dir-search" class="form-control" placeholder="Search by company name..." style="flex:1; min-width:200px;">
        <select id="dir-industry" class="form-select" style="width:220px;">
          <option value="">All Industries</option>
          <option value="DeepTech / AI">DeepTech / AI</option>
          <option value="FinTech">FinTech</option>
          <option value="HealthTech / MedTech">HealthTech / MedTech</option>
        </select>
      </div>
      <div class="table-responsive">
        <table class="custom-table">
          <thead><tr><th>Company</th><th>Industry</th><th>Score</th><th>Verification ID</th><th>Status</th></tr></thead>
          <tbody id="dir-body"></tbody>
        </table>
      </div>
      <div id="dir-empty" class="empty-state" style="display:none;">
        <div class="empty-state-icon">🔍</div>
        <h3>No Verified Companies Found</h3>
      </div>
    </div>
  </main>
</div>

<script>
// ===== Count-up for metric cards =====
function animateCount(el, target, duration = 1200) {
  let startTime = null;
  function update(t) {
    if (!startTime) startTime = t;
    const p = Math.min((t - startTime) / duration, 1);
    el.textContent = Math.floor(p * target);
    if (p < 1) requestAnimationFrame(update); else el.textContent = target;
  }
  requestAnimationFrame(update);
}
document.querySelectorAll('.metric-val').forEach(el => {
  const n = parseInt(el.textContent.replace(/[^0-9]/g, ''));
  if (!isNaN(n)) animateCount(el, n);
});

// ===== Sidebar & logout =====
document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
  document.querySelector('.sidebar').classList.toggle('collapsed');
  this.classList.toggle('active');
});
document.getElementById('btn-logout')?.addEventListener('click', async function() {
  await fetch('<?= base_url('api/logout') ?>', { method: 'POST', credentials: 'same-origin' });
  window.location.href = '<?= base_url('login') ?>';
});

// ===== Certificate card (approved IDs only) =====
function showCertificate(verId, score) {
  if (!verId || !verId.startsWith('CREDENCE-TD-')) { alert('Ye Verification ID approved nahi hai.'); return; }
  document.getElementById('cert-ver-id').textContent = verId;
  document.getElementById('cert-qr-text').textContent = verId;
  document.getElementById('cert-score').textContent = (score ?? '--') + ' / 100';
  const box = document.getElementById('cert-qr-canvas');
  box.innerHTML = '';
  new QRCode(box, {
    text: 'http://localhost:8080/verify?id=' + verId,
    width: 120, height: 120,
    colorDark: '#0F6E5C', colorLight: '#ffffff'
  });
  const dl = document.getElementById('cert-download-btn');
dl.href = '<?= base_url('api/certificate/download') ?>/' + encodeURIComponent(verId);
dl.style.display = 'inline-flex';
  document.getElementById('certificate-card').style.display = 'block';
}

// ===== Sidebar status (steps 5–8) =====
function setSidebarStatus(s) {
  const update = (step, text, cls) => {
    const link = document.querySelector(`.sidebar .nav-link[data-step="${step}"]`);
    link.className = 'nav-link ' + cls;
    document.getElementById('side-st' + step).textContent = text;
  };
  update(5, s.evaluator ? 'Assigned: ' + s.evaluator : 'Locked', s.evaluator ? 'done' : 'locked');
  update(6, s.evaluationStatus === 'Completed' ? 'Score: ' + s.finalScore : (s.evaluationStatus || 'Locked'), s.evaluationStatus === 'Completed' ? 'done' : (s.evaluator ? 'active-step' : 'locked'));
  update(7, s.reviewStatus || 'Locked', s.reviewStatus === 'Approved' || s.reviewStatus === 'Rejected' ? 'done' : (s.evaluationStatus === 'Completed' ? 'active-step' : 'locked'));
  update(8, s.certificate === 'Available' ? 'Available' : 'Locked', s.certificate === 'Available' ? 'done' : 'locked');
}

// ===== Verified directory (demo) =====
const demoDirectory = [
  { company: 'Demo Tech Pvt Ltd', industry: 'DeepTech / AI', score: 78, verId: 'CREDENCE-TD-2026-12345', status: 'Active' },
  { company: 'FinNova Systems', industry: 'FinTech', score: 86, verId: 'CREDENCE-TD-2026-00221', status: 'Active' },
  { company: 'MediCore Labs', industry: 'HealthTech / MedTech', score: 82, verId: 'CREDENCE-TD-2026-00317', status: 'Active' }
];
function renderDirectory() {
  const q = document.getElementById('dir-search').value.trim().toLowerCase();
  const ind = document.getElementById('dir-industry').value;
  const rows = demoDirectory.filter(c => c.company.toLowerCase().includes(q) && (ind === '' || c.industry === ind));
  document.getElementById('dir-body').innerHTML = rows.map(c => `
    <tr>
      <td><strong>${c.company}</strong></td>
      <td>${c.industry}</td>
      <td>${c.score} / 100</td>
      <td><code>${c.verId}</code></td>
      <td><span class="badge badge-active">${c.status}</span></td>
    </tr>`).join('');
  document.getElementById('dir-empty').style.display = rows.length ? 'none' : 'block';
}
document.getElementById('dir-search').addEventListener('input', renderDirectory);
document.getElementById('dir-industry').addEventListener('change', renderDirectory);
renderDirectory();
</script>

</body>
</html>