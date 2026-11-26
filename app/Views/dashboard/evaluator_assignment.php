<?php
$isPaid = !empty($isPaid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Evaluator Assignment — Credence</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>

<body>

<div class="app-wrapper active" id="app-wrapper">

    <!-- HEADER -->
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

        <!-- SIDEBAR -->
        <aside class="sidebar">

            <div class="role-nav role-startup">

                <div class="sidebar-title">Startup Portal</div>

                <a class="nav-link" href="<?= base_url('dashboard') ?>">
                    Dashboard & Status
                </a>

                <a class="nav-link" href="<?= base_url('profile') ?>">
                    Company Profile
                </a>

                <a class="nav-link" href="<?= base_url('documents') ?>">
                    Document Manager
                </a>

                <a class="nav-link" href="<?= base_url('apply') ?>">
                    Assessment Application
                </a>

                <div style="margin-top:15px;padding-top:12px;border-top:1px solid var(--light-border);">

                    <div class="sidebar-title">Assessment Workflow</div>

                    <a class="nav-link active" href="<?= base_url('evaluator-assignment') ?>">
                        Evaluator Assignment
                        <span style="margin-left:auto;"><?= $isPaid ? '✓' : '🔒' ?></span>
                    </a>

                    <a class="nav-link" href="<?= base_url('evaluation-scoring') ?>">
                        Evaluation & Scoring
                        <span style="margin-left:auto;"><?= $isPaid ? '✓' : '🔒' ?></span>
                    </a>

                    <a class="nav-link" href="<?= base_url('credence-review') ?>">
                        Credence Review
                        <span style="margin-left:auto;"><?= $isPaid ? '✓' : '🔒' ?></span>
                    </a>

                    <a class="nav-link" href="<?= base_url('certificate-verification') ?>">
                        Certificate & QR Verification
                        <span style="margin-left:auto;"><?= $isPaid ? '✓' : '🔒' ?></span>
                    </a>

                </div>

            </div>

        </aside>

        <!-- MAIN CONTENT -->
        <main class="main-content">

            <div class="page-header">
                <h1 class="page-title">Evaluator Assignment</h1>
                <p class="page-desc">
                    Track the evaluator assigned to your Credence assessment.
                </p>
            </div>

            <!-- WORKFLOW PROGRESS -->
            <div class="workflow-wizard">

                <div class="workflow-wizard-title">
                    Assessment Workflow Progress
                </div>

                <div class="wizard-steps-8">

                    <div class="wizard-step-8 completed" data-step="1">
                        <div class="step-8-circle">✓</div>
                        <div class="step-8-label">Registration</div>
                    </div>

                    <div class="wizard-step-8 completed" data-step="2">
                        <div class="step-8-circle">✓</div>
                        <div class="step-8-label">Company Profile</div>
                    </div>

                    <div class="wizard-step-8 completed" data-step="3">
                        <div class="step-8-circle">✓</div>
                        <div class="step-8-label">Documents</div>
                    </div>

                    <div class="wizard-step-8 completed" data-step="4">
                        <div class="step-8-circle">✓</div>
                        <div class="step-8-label">Assessment Application</div>
                    </div>

                    <div class="wizard-step-8 active" data-step="5">
                        <div class="step-8-circle">5</div>
                        <div class="step-8-label">Evaluator Assignment</div>
                    </div>

                    <div class="wizard-step-8 locked" data-step="6">
                        <div class="step-8-circle">6</div>
                        <div class="step-8-label">Evaluation & Scoring</div>
                    </div>

                    <div class="wizard-step-8 locked" data-step="7">
                        <div class="step-8-circle">7</div>
                        <div class="step-8-label">Credence Review</div>
                    </div>

                    <div class="wizard-step-8 locked" data-step="8">
                        <div class="step-8-circle">8</div>
                        <div class="step-8-label">Certificate & QR</div>
                    </div>

                </div>

            </div>

            <!-- EVALUATOR CONTENT -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Evaluator Assignment Details</h3>
                </div>

                <?php if (!$isPaid): ?>

                    <div style="text-align:center;padding:45px 20px;">

                        <div style="font-size:48px;">🔒</div>

                        <h2>Evaluator Assignment Locked</h2>

                        <p>
                            Complete your assessment application payment
                            to unlock this section.
                        </p>

                        <a href="<?= base_url('apply') ?>" class="btn btn-primary">
                            Go to Assessment Application
                        </a>

                    </div>

                <?php else: ?>

                    <div style="margin-bottom:20px;">
                        <span class="badge badge-active">Payment Verified</span>
                    </div>

                    <div class="metrics-grid">

                        <div class="metric-card">
                            <div class="metric-icon">👤</div>
                            <div>
                                <div class="metric-val">
                                    <?= esc($evaluatorName ?? 'Not Assigned Yet') ?>
                                </div>
                                <div class="metric-label">Evaluator Name</div>
                            </div>
                        </div>

                        <div class="metric-card">
                            <div class="metric-icon">⏳</div>
                            <div>
                                <div class="metric-val">
                                    <?= esc($assignmentStatus ?? 'Pending') ?>
                                </div>
                                <div class="metric-label">Assignment Status</div>
                            </div>
                        </div>

                    </div>

                    <p style="margin-top:20px;color:#64748b;">
                        Your evaluator details will appear here once an
                        evaluator is assigned by the Credence Admin.
                    </p>

                <?php endif; ?>

            </div>

        </main>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.getElementById('sidebar-toggle')?.addEventListener('click', function () {
        document.querySelector('.sidebar')?.classList.toggle('collapsed');
        this.classList.toggle('active');
    });

    document.getElementById('btn-logout')?.addEventListener('click', async function () {

        try {
            await fetch('<?= base_url('api/logout') ?>', {
                method: 'POST',
                credentials: 'same-origin'
            });
        } catch (error) {
            console.error('Logout failed:', error);
        }

        window.location.href = '<?= base_url('login') ?>';
    });

});
</script>

</body>
</html>