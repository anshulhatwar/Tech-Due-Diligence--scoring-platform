<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assessment Application — CREDENCE</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>
<?php $title = 'Assessment Application'; ?>

<header class="navbar">
   <button id="sidebar-toggle" class="hamburger-btn">
  <span class="bar bar1"></span>
  <span class="bar bar2"></span>
  <span class="bar bar3"></span>
</button>
  <a href="#" class="brand-logo">
    <div class="brand-badge">CREDENCE</div>
    <div>
      <div class="brand-title">Tech Due-Diligence & Trust Score</div>
      <span class="brand-sub">Verification & Assessment Platform</span>
    </div>
  </a>

  <div class="nav-controls">
    <div class="nav-user-info">
      <div class="nav-user-avatar" id="nav-user-avatar">VS</div>
      <span id="nav-user-name">Vikram Seth</span>
    </div>
    <button class="nav-logout-btn" id="btn-logout">Logout</button>
  </div>
</header>

<div class="app-container">
  <aside class="sidebar">
    <div class="role-nav role-startup">
      <div class="sidebar-title">Startup Portal</div>
      <a class="nav-link" href="<?= base_url('dashboard') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
        Dashboard & Status
      </a>
      <a class="nav-link" href="<?= base_url('profile') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
        Company Profile
      </a>
      <a class="nav-link" href="<?= base_url('documents') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
        Document Manager
      </a>
      <a class="nav-link active" href="<?= base_url('apply') ?>">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
        Assessment Application
      </a>
    </div>
  </aside>

  <main class="main-content">
    <div class="page-header">
      <h1 class="page-title">Apply for CREDENCE Assessment</h1>
      <p class="page-desc">Submit your company for official CREDENCE Tech Due-Diligence & Verification Certification</p>
    </div>

    <div class="card" id="apply-card">
      <div class="card-header">
        <h3 class="card-title">Assessment Application Tier</h3>
      </div>
      <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:var(--radius-md); padding:1.25rem; margin-bottom:1.5rem;">
        <h4 style="font-family:'Outfit',sans-serif; font-size:1.3rem; color:var(--primary); margin-bottom:4px;">
          Full CREDENCE Tech Due-Diligence & Trust Score Assessment
        </h4>
        <p style="font-size:0.92rem; color:#334155;">
          Includes 9-parameter expert evaluator assessment, dynamic score report, unique Verification ID issuance, QR code digital badge, and listing in the public CREDENCE Verified Directory.
        </p>
        <div style="margin-top:12px; font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#0f172a;">
          Assessment Fee: ₹4,999 <small style="font-size:0.85rem; color:#64748b; font-weight:normal;">+ GST</small>
        </div>
      </div>

      <button id="btn-trigger-payment" class="btn btn-primary">Proceed to Payment & Submit Application</button>
    </div>
  </main>
</div>

<script>
document.getElementById('btn-trigger-payment').addEventListener('click', function() {
  alert('Payment gateway abhi connect nahi hua hai — backend teammate se baat karni hai Razorpay/payment API ke liye.');
});

document.getElementById('btn-logout')?.addEventListener('click', async function() {
  await fetch('<?= base_url('api/logout') ?>', { method: 'POST' });
  window.location.href = '<?= base_url('login') ?>';
});
 document.getElementById('sidebar-toggle')?.addEventListener('click', function() {
  const sidebar = document.querySelector('.sidebar');
  sidebar.classList.toggle('collapsed');
  this.classList.toggle('active');
  
  // Button pe chhota bounce effect
  this.style.transform = 'scale(0.85)';
  setTimeout(() => { this.style.transform = 'scale(1)'; }, 150);
});
</script>
</body>
</html>