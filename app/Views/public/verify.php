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

        <h1 class="page-title" style="margin-bottom:0.5rem;">
            Verify a Certificate
        </h1>

        <p class="page-desc" style="margin-bottom:1.5rem;">
            Enter the CREDENCE Verification ID to check authenticity.
        </p>

        <form id="verify-form">

            <div style="display:flex; gap:10px; max-width:520px; margin:0 auto;">

                <input
                    type="text"
                    id="verify-input"
                    class="form-control"
                    placeholder="e.g. CRD-XXXXXXXXXXXX"
                    required
                    style="flex:1; min-width:0;"
                >

                <button
                    type="submit"
                    class="btn btn-primary"
                    id="btn-verify"
                >
                    Verify
                </button>

            </div>

        </form>

    </div>

    <div
        id="verify-result"
        class="card"
        style="display:none; margin-top:1.5rem; padding:25px;"
    ></div>

</section>

<script>

const verifyForm = document.getElementById('verify-form');
const verifyInput = document.getElementById('verify-input');
const verifyButton = document.getElementById('btn-verify');
const resultBox = document.getElementById('verify-result');

// Verify certificate
async function verifyCertificate(verificationId) {

    verificationId = verificationId.trim().toUpperCase();

    if (!verificationId) {
        return;
    }

    verifyInput.value = verificationId;

    verifyButton.disabled = true;
    verifyButton.textContent = 'Verifying...';

    resultBox.style.display = 'block';

    resultBox.innerHTML = `
        <p style="text-align:center;">
            Checking certificate authenticity...
        </p>
    `;

    try {

        const response = await fetch(
            '<?= site_url('api/verify-certificate') ?>?id=' +
            encodeURIComponent(verificationId)
        );

        const data = await response.json();

        if (!response.ok || !data.status) {

            resultBox.innerHTML = `
                <div style="color:#dc2626; font-weight:700; font-size:1.2rem; text-align:center;">
                    ✖ Certificate Not Verified
                </div>

                <p style="margin-top:10px; text-align:center;">
                    ${escapeHTML(data.message || 'Invalid or unapproved certificate.')}
                </p>
            `;

            return;
        }

        const cert = data.certificate;

        resultBox.innerHTML = `

            <div style="color:#16a34a; font-weight:700; font-size:1.3rem; text-align:center; margin-bottom:20px;">
                ✓ Valid CREDENCE Certificate
            </div>

            <hr>

            <p style="margin:14px 0;">
                <strong>Company:</strong>
                ${escapeHTML(cert.company_name)}
            </p>

            <p style="margin:14px 0;">
                <strong>Verification ID:</strong>
                ${escapeHTML(cert.verification_id)}
            </p>

            <p style="margin:14px 0;">
                <strong>Application Number:</strong>
                ${escapeHTML(cert.application_number)}
            </p>

            <p style="margin:14px 0;">
                <strong>Assessment Type:</strong>
                ${escapeHTML(cert.assessment_type)}
            </p>

            <p style="margin:14px 0;">
                <strong>Trust Score:</strong>
                ${escapeHTML(cert.total_score)} / 100
            </p>

            <p style="margin:14px 0;">
                <strong>Issue Date:</strong>
                ${escapeHTML(cert.certificate_issued_at || 'Not available')}
            </p>

            <p style="margin:14px 0;">
                <strong>Status:</strong>
                <span style="color:#16a34a; font-weight:700;">
                    Approved
                </span>
            </p>

        `;

    } catch (error) {

        resultBox.innerHTML = `
            <div style="color:#dc2626; font-weight:700; text-align:center;">
                Unable to connect to the verification server.
            </div>

            <p style="text-align:center;">
                Please try again later.
            </p>
        `;

    } finally {

        verifyButton.disabled = false;
        verifyButton.textContent = 'Verify';

    }

}

// Manual verification
verifyForm.addEventListener('submit', function(event) {

    event.preventDefault();

    verifyCertificate(verifyInput.value);

});

// Escape HTML
function escapeHTML(value) {

    return String(value ?? '').replace(/[&<>"']/g, function(char) {

        return {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        }[char];

    });

}

// QR code automatic verification
document.addEventListener('DOMContentLoaded', function() {

    const params = new URLSearchParams(window.location.search);

    const verificationId = params.get('id');

    if (verificationId) {

        verifyCertificate(verificationId);

    }

});

</script>

</body>
</html>