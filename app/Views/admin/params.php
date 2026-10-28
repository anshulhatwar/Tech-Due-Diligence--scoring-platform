<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assessment Parameters — CREDENCE</title>
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
      <a class="nav-link" href="<?= base_url('admin') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10"></path></svg>
        Applications Overview
      </a>
      <a class="nav-link active" href="<?= base_url('admin/params') ?>">
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
      <h1 class="page-title">Assessment Parameter & Weight Configurator</h1>
      <p class="page-desc">Define and configure weightage for CREDENCE Tech Due-Diligence evaluation parameters</p>
    </div>

    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Configured Parameters (Total Weight: <span id="total-weight" style="color:var(--primary);">100%</span>)</h3>
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
          <tbody id="params-table-body"></tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<script>
const defaultParams = [
  { name: 'Technology Stack', desc: 'Quality, scalability and modernity of tech stack', weight: 15 },
  { name: 'Architecture & Scalability', desc: 'System design and ability to scale', weight: 12 },
  { name: 'Security & Compliance', desc: 'Data protection, security practices, compliance', weight: 15 },
  { name: 'Intellectual Property', desc: 'Patents, IP filings and proprietary tech', weight: 10 },
  { name: 'Team & Technical Expertise', desc: 'Founder and team technical capability', weight: 10 },
  { name: 'Product Maturity', desc: 'Stage and stability of the product', weight: 10 },
  { name: 'Market & Business Model', desc: 'Revenue model and market potential', weight: 10 },
  { name: 'Financial Health', desc: 'Financial stability and runway', weight: 10 },
  { name: 'Legal & Governance', desc: 'Legal structure, documentation and governance', weight: 8 }
];

const tbody = document.getElementById('params-table-body');
const totalEl = document.getElementById('total-weight');

function renderParams() {
  tbody.innerHTML = '';
  defaultParams.forEach((p, i) => {
    tbody.insertAdjacentHTML('beforeend', `
      <tr>
        <td><strong>${p.name}</strong></td>
        <td>${p.desc}</td>
        <td><input type="number" class="form-control" value="${p.weight}" min="0" max="100" data-idx="${i}" style="width:100px;"></td>
      </tr>`);
  });
  updateTotal();
}

function updateTotal() {
  const total = defaultParams.reduce((sum, p) => sum + Number(p.weight), 0);
  totalEl.textContent = total + '%';
  totalEl.style.color = total === 100 ? 'var(--primary)' : '#dc2626';
}

tbody.addEventListener('input', function(e) {
  const idx = e.target.dataset.idx;
  if (idx !== undefined) {
    defaultParams[idx].weight = Number(e.target.value) || 0;
    updateTotal();
  }
});

document.getElementById('btn-save-params').addEventListener('click', function() {
  const total = defaultParams.reduce((sum, p) => sum + Number(p.weight), 0);
  if (total !== 100) {
    alert('Total weightage 100% hona chahiye. Abhi: ' + total + '%');
    return;
  }
  alert('Parameters saved (abhi demo mode — backend API se connect karna baaki hai).');
});

document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
  document.querySelector('.sidebar').classList.toggle('collapsed');
  this.classList.toggle('active');
});

document.getElementById('btn-logout')?.addEventListener('click', async function() {
  await fetch('<?= base_url('api/logout') ?>', { method: 'POST' });
  window.location.href = '<?= base_url('login') ?>';
});

renderParams();
</script>

</body>
</html>