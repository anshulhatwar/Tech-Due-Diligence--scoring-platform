<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate & QR Verification | Credence</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 30px 15px;
            font-family: Arial, sans-serif;
            background: #f4f6fb;
            color: #202938;
        }

        .container {
            max-width: 850px;
            margin: 30px auto;
            background: #fff;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.07);
        }

        h1 {
            margin-top: 0;
            color: #172554;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 30px;
        }

        .status {
            padding: 14px;
            background: #f1f5f9;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-top: 25px;
        }

        .detail {
            padding: 17px;
            background: #f8fafc;
            border-radius: 8px;
        }

        .label {
            display: block;
            color: #64748b;
            font-size: 13px;
            margin-bottom: 8px;
        }

        .value {
            font-weight: bold;
            overflow-wrap: anywhere;
        }

        .qr-section {
            text-align: center;
            margin: 30px 0;
        }

        .qr-section img {
            width: 190px;
            max-width: 100%;
            border: 1px solid #e2e8f0;
            padding: 10px;
            border-radius: 8px;
        }

        .button {
            display: inline-block;
            padding: 12px 20px;
            margin: 8px 5px;
            border-radius: 6px;
            text-decoration: none;
            color: white;
            background: #1d4ed8;
        }

        .secondary {
            background: #475569;
        }

        .actions {
            text-align: center;
            margin-top: 25px;
        }

        @media(max-width: 600px) {
            .details {
                grid-template-columns: 1fr;
            }

            .container {
                padding: 22px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Certificate & QR Verification</h1>

    <p class="subtitle">
        View your Credence assessment certificate and verification details.
    </p>

    <div class="status">
        <strong>Certificate Status:</strong>
        <?= esc($certificateStatus ?? 'Not Issued') ?>
        <br><br>

        <strong>Verification Status:</strong>
        <?= esc($verificationStatus ?? 'Not Issued') ?>
    </div>

    <div class="details">

        <div class="detail">
            <span class="label">Payment Status</span>
            <span class="value">
                <?= esc($paymentStatus ?? 'Unpaid') ?>
            </span>
        </div>

        <div class="detail">
            <span class="label">Approval Status</span>
            <span class="value">
                <?= esc($approvalStatus ?? 'Awaiting') ?>
            </span>
        </div>

        <div class="detail">
            <span class="label">Final Trust Score</span>
            <span class="value">
                <?= esc($finalScore ?? '-- / 100') ?>
            </span>
        </div>

        <div class="detail">
            <span class="label">Verification ID</span>
            <span class="value">
                <?= esc($verificationId ?? 'Not Available') ?>
            </span>
        </div>

        <div class="detail">
            <span class="label">Certificate Issue Date</span>
            <span class="value">
                <?php if (!empty($issueDate)): ?>
                    <?= esc(date('d M Y', strtotime($issueDate))) ?>
                <?php else: ?>
                    Not Issued
                <?php endif; ?>
            </span>
        </div>

        <div class="detail">
            <span class="label">QR Code Status</span>
            <span class="value">
                <?= esc($qrStatus ?? 'Not Available') ?>
            </span>
        </div>

    </div>

    <?php if (!empty($isCertificateGenerated)): ?>

        <div class="qr-section">

            <h3>Certificate QR Code</h3>

            <?php if (!empty($qrImageData)): ?>
                <img src="<?= esc($qrImageData) ?>" alt="Certificate QR Code">
            <?php else: ?>
                <p>QR image is currently unavailable.</p>
            <?php endif; ?>

            <p>Scan the QR code to verify this certificate.</p>

        </div>

        <div class="actions">

            <?php if (!empty($downloadUrl)): ?>
                <a class="button" href="<?= esc($downloadUrl) ?>">
                    Download Certificate PDF
                </a>
            <?php endif; ?>

            <a class="button secondary"
               href="<?= esc($verificationUrl) ?>"
               target="_blank">
                Public Verification
            </a>

        </div>

    <?php else: ?>

        <div class="status">
            Your certificate has not been generated yet.
            Please wait for the required approval and certificate generation.
        </div>

    <?php endif; ?>

    <div class="actions">
        <a class="button secondary" href="<?= base_url('dashboard') ?>">
            Back to Dashboard
        </a>
    </div>

</div>

</body>
</html>