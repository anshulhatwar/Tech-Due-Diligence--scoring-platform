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
  <aside class="sidebar">
    <div class="role-nav">
      <div class="sidebar-title">CREDENCE Admin</div>
      <a class="nav-link active" href="<?= base_url('admin') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"></path></svg>
        Applications Overview
      </a>
      <a class="nav-link" href="<?= base_url('admin/params') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10"></path></svg>
        Assessment Parameters
      </a>
      <a class="nav-link" href="<?= base_url('eval') ?>">
  <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
  Assigned Queue
</a>
    </div>
  </aside>

  <main class="main-content">
    <div class="page-header">
      <h1 class="page-title">CREDENCE Admin Dashboard</h1>
      <p class="page-desc">Manage startup assessment applications, evaluator assignments, and certificates</p>
    </div>

    <div class="metrics-grid">
      <div class="metric-card">
        <div class="metric-icon">📋</div>
        <div>
          <div class="metric-val">0</div>
          <div class="metric-label">Total Applications</div>
        </div>
      </div>
      <div class="metric-card">
        <div class="metric-icon">⏳</div>
        <div>
          <div class="metric-val">0</div>
          <div class="metric-label">Under Review</div>
        </div>
      </div>
      <div class="metric-card">
        <div class="metric-icon">🛡️</div>
        <div>
          <div class="metric-val">0</div>
          <div class="metric-label">Active Verifications</div>
        </div>
      </div>
      <div class="metric-card">
        <div class="metric-icon">💰</div>
        <div>
          <div class="metric-val">0</div>
          <div class="metric-label">Assessment Revenue</div>
        </div>
      </div>
    </div>

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
          <tbody>
  <tr>
    <td>Demo Tech Pvt Ltd</td>
    <td><span class="badge badge-new">Submitted</span></td>
    <td id="assigned-eval-demo">Not Assigned</td>
    <td>--</td>
    <td>--</td>
    <td>
      <button class="btn btn-primary btn-sm" onclick="openAssignModal('Demo Tech Pvt Ltd')">Assign Evaluator</button>
      <button class="btn btn-success btn-sm" onclick="openReview('Demo Tech Pvt Ltd')" style="margin-left:6px;">Review</button>
    </td>
  </tr>
</tbody>
        </table>
      </div>
    </div>
    <!-- Assign Evaluator Modal -->
<div class="modal-backdrop" id="assign-modal">
  <div class="modal-box">
    <div class="modal-header">
      <h3 class="card-title">Assign Evaluator to <span id="assign-company"></span></h3>
      <button class="modal-close" onclick="closeAssign()">&times;</button>
    </div>
    <div class="form-group">
      <label class="form-label">Select Qualified Evaluator</label>
      <select id="assign-evaluator-select" class="form-select">
        <option value="">-- Select Evaluator --</option>
        <option value="Anshul ">Anshul  (DeepTech / AI)</option>
        <option value="Madhur">Madhur (FinTech)</option>
        <option value="Aryan">Aryan (HealthTech)</option>
      </select>
    </div>
    <div style="display:flex; justify-content:flex-end; gap:10px; margin-top:1rem;">
      <button class="btn btn-secondary" onclick="closeAssign()">Cancel</button>
      <button class="btn btn-primary" onclick="confirmAssign()">Assign & Notify Evaluator</button>
    </div>
  </div>
</div>
<!-- Review & Certificate Modal -->
<div class="modal-backdrop" id="review-modal">
  <div class="modal-box" style="max-width:600px;">
    <div class="modal-header">
      <h3 class="card-title">Review: <span id="review-company"></span></h3>
      <button class="modal-close" onclick="closeReview()">&times;</button>
    </div>

    <div style="background:#f8fafc; padding:12px; border-radius:var(--radius-md); margin-bottom:1rem; border:1px solid #e2e8f0;">
      <strong>Evaluator Score:</strong> <span id="review-score" style="color:var(--primary); font-weight:700;">78 / 100</span><br>
      <strong>Evaluator:</strong> <span id="review-evaluator">Anshul</span>
    </div>

    <div class="form-group">
      <label class="form-label">CREDENCE Verification ID</label>
      <input type="text" id="review-verid" class="form-control" readonly>
    </div>

    <div id="review-qr" style="text-align:center; margin:1rem 0;"></div>

    <div style="display:flex; justify-content:flex-end; gap:10px;">
      <button class="btn btn-secondary" onclick="closeReview()">Cancel</button>
      <button class="btn btn-danger" onclick="rejectReview()">Reject</button>
      <button class="btn btn-success" onclick="approveReview()">Approve & Issue Certificate</button>
    </div>
  </div>
</div>
<!-- Review & Certificate Modal -->
<div class="modal-backdrop" id="review-modal">
  <div class="modal-box" style="max-width:600px;">
    <div class="modal-header">
      <h3 class="card-title">Review: <span id="review-company"></span></h3>
      <button class="modal-close" onclick="closeReview()">&times;</button>
    </div>

    <div style="background:#f8fafc; padding:12px; border-radius:var(--radius-md); margin-bottom:1rem; border:1px solid #e2e8f0;">
      <strong>Evaluator Score:</strong> <span id="review-score" style="color:var(--primary); font-weight:700;">78 / 100</span><br>
      <strong>Evaluator:</strong> <span id="review-evaluator">Rahul Mehta</span>
    </div>

    <div class="form-group">
      <label class="form-label">CREDENCE Verification ID</label>
      <input type="text" id="review-verid" class="form-control" readonly>
    </div>

    <div id="review-qr" style="text-align:center; margin:1rem 0;"></div>

    <div style="display:flex; justify-content:flex-end; gap:10px;">
      <button class="btn btn-secondary" onclick="closeReview()">Cancel</button>
      <button class="btn btn-danger" onclick="rejectReview()">Reject</button>
      <button class="btn btn-success" onclick="approveReview()">Approve & Issue Certificate</button>
    </div>
  </div>
</div>
  </main>
</div>

<script>
document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
  document.querySelector('.sidebar').classList.toggle('collapsed');
  this.classList.toggle('active');
});

document.getElementById('btn-logout')?.addEventListener('click', async function() {
  await fetch('<?= base_url('api/logout') ?>', { method: 'POST' });
  window.location.href = '<?= base_url('login') ?>';
});
let currentAssignCompany = null;

function openAssignModal(company) {
  currentAssignCompany = company;
  document.getElementById('assign-company').textContent = company;
  document.getElementById('assign-modal').classList.add('active');
}

function closeAssign() {
  document.getElementById('assign-modal').classList.remove('active');
}

function confirmAssign() {
  const evaluator = document.getElementById('assign-evaluator-select').value;
  if (!evaluator) {
    alert('Pehle evaluator select karo');
    return;
  }
  document.getElementById('assigned-eval-demo').textContent = evaluator;
  alert(evaluator + ' ko assign ho gaya (demo). Backend API baaki hai.');
  closeAssign();
}
function generateVerId() {
  const year = new Date().getFullYear();
  const rand = String(Math.floor(Math.random() * 100000)).padStart(5, '0');
  return `CREDENCE-TD-${year}-${rand}`;
}

function openReview(company) {
  document.getElementById('review-company').textContent = company;
  document.getElementById('review-verid').value = '(Approve karne par generate hoga)';
  document.getElementById('review-qr').innerHTML = '';
  document.getElementById('review-modal').classList.add('active');
}

function closeReview() {
  document.getElementById('review-modal').classList.remove('active');
}

function rejectReview() {
  alert('Application reject ho gayi (demo). Backend API baaki hai.');
  closeReview();
}

function approveReview() {
  const verId = generateVerId();
  document.getElementById('review-verid').value = verId;
  document.getElementById('review-qr').innerHTML =
    '<div style="display:inline-block; padding:12px; background:#fff; border:2px solid var(--primary); border-radius:8px;">' +
    '<div style="font-size:0.8rem; color:#64748b;">QR Code (demo)</div>' +
    '<div style="font-family:monospace; font-weight:700; margin-top:6px;">' + verId + '</div>' +
    '</div>';
  alert('Certificate issue ho gaya (demo). Backend se Verification ID aur QR generate karna baaki hai.');
}
function generateVerId() {
  const year = new Date().getFullYear();
  const rand = String(Math.floor(Math.random() * 100000)).padStart(5, '0');
  return `CREDENCE-TD-${year}-${rand}`;
}

function openReview(company) {
  document.getElementById('review-company').textContent = company;
  document.getElementById('review-verid').value = '(Approve karne par generate hoga)';
  document.getElementById('review-qr').innerHTML = '';
  document.getElementById('review-modal').classList.add('active');
}

function closeReview() {
  document.getElementById('review-modal').classList.remove('active');
}

function rejectReview() {
  alert('Application reject ho gayi (demo). Backend API baaki hai.');
  closeReview();
}

function approveReview() {
  const verId = generateVerId();
  document.getElementById('review-verid').value = verId;
  document.getElementById('review-qr').innerHTML =
    '<div style="display:inline-block; padding:12px; background:#fff; border:2px solid var(--primary); border-radius:8px;">' +
    '<div style="font-size:0.8rem; color:#64748b;">QR Code (demo)</div>' +
    '<div style="font-family:monospace; font-weight:700; margin-top:6px;">' + verId + '</div>' +
    '</div>';
  alert('Certificate issue ho gaya (demo). Backend se Verification ID aur QR generate karna baaki hai.');
}
</script>

</body>
</html>