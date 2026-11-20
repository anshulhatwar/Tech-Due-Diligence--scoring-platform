<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<div class="app-wrapper active" id="app-wrapper">
    <header class="navbar">
        <a href="<?= base_url('admin') ?>" class="brand-logo">
            <img src="<?= base_url('images/logo.png') ?>" alt="ICTRD Credence" style="height:34px;">
            <div>
                <div class="brand-title">ICTRD Admin Portal</div>
                <span class="brand-sub">Trust Score & Scoring Panel</span>
            </div>
        </a>
        <div class="nav-controls">
            <div class="nav-user-info">
                <div class="nav-user-avatar" style="background:var(--amber);">AD</div>
                <span>Admin Master</span>
            </div>
            <a href="<?= base_url('login') ?>" class="nav-logout-btn">Logout</a>
        </div>
    </header>

    <div class="app-container">
        <aside class="sidebar">
            <div class="sidebar-title">Admin Navigation</div>
            <a class="nav-link" href="<?= base_url('admin') ?>">Dashboard Overview</a>
            <a class="nav-link" href="<?= base_url('admin/companies') ?>">Company Verifications</a>
            <a class="nav-link active" href="<?= base_url('admin/assessments') ?>">Trust Score & Scoring</a>
        </aside>

        <main class="main-content">
            <div class="page-header">
                <h1 class="page-title">Trust Score Evaluator & Assessment</h1>
                <p class="page-desc">Allocate parameter weights to generate official ICTRD Trust Score & Verification badge.</p>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Select Company for Evaluation</h3>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">Company Name</label>
                        <select class="form-select" id="eval-company-select">
                            <option value="QuantumAI Labs">QuantumAI Labs (DeepTech)</option>
                            <option value="BioMedics India">BioMedics India (HealthTech)</option>
                            <option value="GreenGrid Energy">GreenGrid Energy (CleanTech)</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Parameter-wise Due-Diligence Scoring (Max 25 pts each)</h3>
                </div>
                <form id="scoring-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label">1. Financial Health & Stability (0 - 25)</label>
                            <input type="number" class="form-control" id="score-financial" min="0" max="25" value="21" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">2. Technology Architecture & Security (0 - 25)</label>
                            <input type="number" class="form-control" id="score-tech" min="0" max="25" value="23" required>
                        </div>
                    </div>
                    <div class="form-row" style="margin-top:1rem;">
                        <div class="form-group">
                            <label class="form-label">3. Legal & Regulatory Compliance (0 - 25)</label>
                            <input type="number" class="form-control" id="score-legal" min="0" max="25" value="20" required>
                        </div>
                        <div class="form-group">
                            <label class="form-label">4. Intellectual Property & USP (0 - 25)</label>
                            <input type="number" class="form-control" id="score-ip" min="0" max="25" value="18" required>
                        </div>
                    </div>

                    <div style="margin-top:1.5rem; display:flex; justify-content:space-between; align-items:center; background:var(--paper); padding:1rem; border-radius:var(--radius-sm);">
                        <div>
                            <span style="font-weight:600; font-size:0.95rem;">Calculated Trust Score:</span>
                            <span id="calculated-total-score" style="font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:var(--primary); margin-left:10px;">82 / 100</span>
                        </div>
                        <button type="button" class="btn btn-primary" onclick="alert('Trust Score successfully published and QR Certificate activated!')">Publish Score & Issue Badge →</button>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>

<script>
    // Live calculation script for scoring form
    const fInput = document.getElementById('score-financial');
    const tInput = document.getElementById('score-tech');
    const lInput = document.getElementById('score-legal');
    const ipInput = document.getElementById('score-ip');
    const totalDisplay = document.getElementById('calculated-total-score');

    function updateScore() {
        let total = parseInt(fInput.value || 0) + parseInt(tInput.value || 0) + parseInt(lInput.value || 0) + parseInt(ipInput.value || 0);
        totalDisplay.innerText = total + ' / 100';
    }

    [fInput, tInput, lInput, ipInput].forEach(inp => {
        inp.addEventListener('input', updateScore);
    });
</script>
</body>
</html>