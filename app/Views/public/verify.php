<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Verify Certificate — Credence</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<header class="home-navbar">
  <a href="<?= base_url('/') ?>" class="brand-logo" style="display:flex; align-items:center; gap:10px;">
    <img src="<?= base_url('images/logo.png') ?>" alt="Credence" style="height:44px;">
  </a>
  <nav class="home-nav-links">
    <a href="<?= base_url('/') ?>">Home</a>
    <a href="<?= base_url('verify') ?>" class="active">Verify</a>
  </nav>
</header>

<section style="max-width:640px; margin:60px auto; padding:0 20px;">
  <div class="card" style="text-align:center; padding:2.5rem 1.5rem;">
    <h1 class="page-title" style="margin-bottom:0.5rem;">Verify a Certificate</h1>
    <p class="page-desc" style="margin-bottom:1.5rem;">Enter the CREDENCE Verification ID to check authenticity</p>

    <div style="display:flex; gap:10px; max-width:520px; margin:0 auto;">
      <input type="text" id="verify-input" class="form-control" placeholder="e.g. CREDENCE-TD-2026-12345">
      <button class="btn btn-primary" id="btn-verify">Verify</button>
    </div>
  </div>

  <div id="verify-result" class="card" style="display:none; margin-top:1.5rem;"></div>
</section>

<script>
// Demo data — backend verify API aane par replace hoga
const demoCertificates = {
  'CREDENCE-TD-2026-12345': { company: 'Demo Tech Pvt Ltd', industry: 'DeepTech / AI', score: 78, status: 'Active', validUntil: '2027-10-29' }
};

document.getElementById('btn-verify').addEventListener('click', function() {
  const id = document.getElementById('verify-input').value.trim().toUpperCase();
  const box = document.getElementById('verify-result');
  const cert = demoCertificates[id];

  box.style.display = 'block';
  if (cert) {
    box.innerHTML = `
      <div style="color:var(--primary); font-weight:700; font-size:1.1rem; margin-bottom:8px;">✓ Valid CREDENCE Certificate</div>
      <p><strong>Company:</strong> ${cert.company}</p>
      <p><strong>Industry:</strong> ${cert.industry}</p>
      <p><strong>Assessment Score:</strong> ${cert.score} / 100</p>
      <p><strong>Status:</strong> ${cert.status}</p>
      <p><strong>Valid Until:</strong> ${cert.validUntil}</p>`;
  } else {
    box.innerHTML = `<div style="color:#dc2626; font-weight:700;">No active CREDENCE certificate found for this ID.</div>`;
  }
});
</script>

</body>
</html>