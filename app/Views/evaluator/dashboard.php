<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Evaluator Workspace — Credence</title>
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
      <div class="nav-user-avatar"><?= esc($userInitials ?? 'EV') ?></div>
      <span><?= esc($userName ?? 'Evaluator') ?></span>
    </div>
    <button class="nav-logout-btn" id="btn-logout">Logout</button>
  </div>
</header>

<div class="app-container">
  <aside class="sidebar">
    <div class="role-nav">
      <div class="sidebar-title">Evaluator Workspace</div>
      <a class="nav-link active" href="<?= base_url('eval') ?>">
        <svg width="17" height="17" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
        Assigned Queue
      </a>
    </div>
  </aside>

  <main class="main-content">
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
              <th>Industry</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Demo Tech Pvt Ltd</td>
              <td>DeepTech / AI</td>
              <td><span class="badge badge-new">Pending Evaluation</span></td>
              <td><button class="btn btn-primary btn-sm" onclick="openEval('Demo Tech Pvt Ltd')">Evaluate</button></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<!-- Evaluation Modal -->
<div class="modal-backdrop" id="eval-modal">
  <div class="modal-box" style="max-width:700px;">
    <div class="modal-header">
      <h3 class="card-title">Evaluate: <span id="eval-company"></span></h3>
      <button class="modal-close" onclick="closeEval()">&times;</button>
    </div>

    <div id="eval-sliders"></div>

    <div class="form-group" style="margin-top:1rem;">
      <label class="form-label">Final Remarks</label>
      <textarea id="eval-remarks" class="form-control" placeholder="Evaluator observations..."></textarea>
    </div>

    <div style="display:flex; justify-content:space-between; align-items:center; margin-top:1rem;">
      <div>Live Score: <strong id="eval-score" style="color:var(--primary);">0</strong> / 100</div>
      <button class="btn btn-primary" onclick="submitEval()">Submit Final Evaluation</button>
    </div>
  </div>
</div>

<script>
const evalParams = [
  { name: 'Technology Stack', weight: 15 },
  { name: 'Architecture & Scalability', weight: 12 },
  { name: 'Security & Compliance', weight: 15 },
  { name: 'Intellectual Property', weight: 10 },
  { name: 'Team & Technical Expertise', weight: 10 },
  { name: 'Product Maturity', weight: 10 },
  { name: 'Market & Business Model', weight: 10 },
  { name: 'Financial Health', weight: 10 },
  { name: 'Legal & Governance', weight: 8 }
];

function openEval(company) {
  document.getElementById('eval-company').textContent = company;
  const box = document.getElementById('eval-sliders');
  box.innerHTML = evalParams.map((p, i) => `
    <div class="form-group">
      <label class="form-label">${p.name} (weight ${p.weight}%): <span id="val-${i}">50</span></label>
      <input type="range" min="0" max="100" value="50" class="eval-slider" data-idx="${i}" style="width:100%;">
    </div>`).join('');
  box.querySelectorAll('.eval-slider').forEach(s => s.addEventListener('input', updateScore));
  updateScore();
  document.getElementById('eval-modal').classList.add('active');
}

function updateScore() {
  let total = 0;
  document.querySelectorAll('.eval-slider').forEach(s => {
    const i = s.dataset.idx;
    document.getElementById('val-' + i).textContent = s.value;
    total += (Number(s.value) * evalParams[i].weight) / 100;
  });
  document.getElementById('eval-score').textContent = Math.round(total);
}

function closeEval() {
  document.getElementById('eval-modal').classList.remove('active');
}

function submitEval() {
  alert('Evaluation submitted (demo). Backend API se connect karna baaki hai.');
  closeEval();
}

document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
  document.querySelector('.sidebar').classList.toggle('collapsed');
  this.classList.toggle('active');
});

document.getElementById('btn-logout')?.addEventListener('click', async function() {
  await fetch('<?= base_url('api/logout') ?>', { method: 'POST' });
  window.location.href = '<?= base_url('login') ?>';
});
</script>

</body>
</html>