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
              <td colspan="6" style="text-align:center; color:#64748b;">No applications yet — backend se data aane par yahan dikhega</td>
            </tr>
          </tbody>
        </table>
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
</script>

</body>
</html>