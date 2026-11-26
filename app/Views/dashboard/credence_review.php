
<?php
$isPaid = !empty($isPaid);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Credence Review — Credence</title>

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

                <a class="nav-link" href="<?= base_url('dashboard') ?>">Dashboard & Status</a>
                <a class="nav-link" href="<?= base_url('profile') ?>">Company Profile</a>
                <a class="nav-link" href="<?= base_url('documents') ?>">Document Manager</a>
                <a class="nav-link" href="<?= base_url('apply') ?>">Assessment Application</a>

                <div style="margin-top:15px;padding-top:12px;border-top:1px solid var(--light-border);">

                    <div class="sidebar-title">Assessment Workflow</div>

                    <a class="nav-link" href="<?= base_url('evaluator-assignment') ?>">
                        Evaluator Assignment
                        <span style="margin-left:auto;"><?= $isPaid ? '✓' : '🔒' ?></span>
                    </a>

                    <a class="nav-link" href="<?= base_url('evaluation-scoring') ?>">
                        Evaluation & Scoring
                        <span style="margin-left:auto;"><?= $isPaid ? '✓' : '🔒' ?></span>
                    </a>

                    <a class="nav-link active" href="<?= base_url('credence-review') ?>">
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
                <h1 class="page-title">Credence Review</h1>

                <p class="page-desc">
                    Track the final review and approval status of your company's assessment.
                </p>
            </div>

            <!-- WORKFLOW PROGRESS -->
            <div class="workflow-wizard">

                <div class="workflow-wizard-title">
                    Assessment Workflow Progress
                </div>

                <div class="wizard-steps-8">

                    <?php
                    $steps = [
                        'Registration',
                        'Company Profile',
                        'Documents',
                        'Assessment Application',
                        'Evaluator Assignment',
                        'Evaluation & Scoring',
                        'Credence Review',
                        'Certificate & QR'
                    ];
                    ?>

                    <?php foreach ($steps as $index => $step): ?>
                        <?php
                        $number = $index + 1;
                        $class = $number <= 4 ? 'completed' : ($number === 7 ? 'active' : 'locked');
                        $circle = $number <= 4 ? '✓' : $number;
                        ?>

                        <div class="wizard-step-8 <?= $class ?>" data-step="<?= $number ?>">
                            <div class="step-8-circle"><?= $circle ?></div>
                            <div class="step-8-label"><?= esc($step) ?></div>
                        </div>

                    <?php endforeach; ?>

                </div>

            </div>

            <!-- CREDENCE REVIEW CONTENT -->
            <div class="card">

                <div class="card-header">
                    <h3 class="card-title">Credence Review Details</h3>
                </div>

                <?php if (!$isPaid): ?>

                    <div style="text-align:center;padding:45px 20px;">

                        <div style="font-size:48px;">🔒</div>

                        <h2>Credence Review Locked</h2>

                        <p>
                            Complete your assessment application payment
                            to unlock the Credence Review section.
                        </p>

                        <a href="<?= base_url('apply') ?>" class="btn btn-primary">
                            Go to Assessment Application
                        </a>

                    </div>

                <?php else: ?>

                    <div style="margin-bottom:20px;">
                        <span class="badge badge-active">Payment Verified</span>
                    </div>
                    <?php
                    $reviewStatus = $reviewStatus ?? 'Not Started';
                    $evaluationStatus = $evaluationStatus ?? 'Not Started';
                    $finalDecision = $finalDecision ?? 'Awaiting';
                    $adminRemarks = $adminRemarks ?? 'Awaiting Review';
                    $reviewDate = $reviewDate ?? null;
                    $finalScore = $finalScore ?? '-- / 100';
                    ?>

                    <div class="metrics-grid">

    <div class="metric-card">
        <div class="metric-icon">📋</div>
        <div>
            <div class="metric-val">
                <?= esc($reviewStatus) ?>
            </div>
            <div class="metric-label">Review Status</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon">📊</div>
        <div>
            <div class="metric-val">
                <?= esc($evaluationStatus) ?>
            </div>
            <div class="metric-label">Evaluation Status</div>
        </div>
    </div>

    <div class="metric-card">
        <div class="metric-icon">⚖️</div>
        <div>
            <div class="metric-val">
                <?= esc($finalDecision) ?>
            </div>
            <div class="metric-label">Final Decision</div>
        </div>
    </div>

</div>

                    <h3 style="margin-top:30px;margin-bottom:15px;">
                        Review Information
                    </h3>

                    <div class="table-responsive">

    <table class="custom-table">

        <thead>
            <tr>
                <th>Sr. No.</th>
                <th>Review Details</th>
                <th>Current Status</th>
            </tr>
        </thead>

        <tbody>

            <tr>
                <td>1</td>
                <td>Payment Verification</td>
                <td>
                    <?php if ($isPaid): ?>
                        <span class="badge badge-active">Verified</span>
                    <?php else: ?>
                        <span class="badge badge-new">Pending</span>
                    <?php endif; ?>
                </td>
            </tr>

            <tr>
                <td>2</td>
                <td>Evaluation Review</td>
                <td><?= esc($evaluationStatus) ?></td>
            </tr>

            <tr>
                <td>3</td>
                <td>Final Approval</td>
                <td><?= esc($finalDecision) ?></td>
            </tr>

            <tr>
                <td>4</td>
                <td>Trust Score</td>
                <td><?= esc($finalScore) ?></td>
            </tr>

            <tr>
                <td>5</td>
                <td>Review Date</td>
                <td>
                    <?= $reviewDate ? esc(date('d-m-Y H:i', strtotime($reviewDate))) : 'Not Reviewed Yet' ?>
                </td>
            </tr>

            <tr>
                <td>6</td>
                <td>Admin Review Remarks</td>
                <td><?= nl2br(esc($adminRemarks)) ?></td>
            </tr>

        </tbody>

    </table>

</div>

                    <p style="margin-top:20px;color:#64748b;">
                        The Credence team will review your evaluation and
                        submitted documents. Final approval and review
                        remarks will appear here after the review is completed.
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