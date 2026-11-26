<?php
$title = 'Assessment Application';
$active = 'apply';

echo view('layouts/dashboard-header', [
    'title'        => $title,
    'userName'     => $userName ?? 'User',
    'userInitials' => $userInitials ?? 'U',
    'sidebar'      => view('layouts/sidebar-startup', ['active' => $active]),
]);
?>

<div class="page-header">
    <h1 class="page-title">Apply for CREDENCE Assessment</h1>
    <p class="page-desc">
        Submit your company for official CREDENCE Tech Due-Diligence & Verification Certification
    </p>
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
            Includes 9-parameter expert evaluator assessment, dynamic score report,
            unique Verification ID issuance, QR code digital badge, and listing
            in the public CREDENCE Verified Directory.
        </p>

        <div style="margin-top:12px; font-family:'Outfit',sans-serif; font-size:1.6rem; font-weight:800; color:#0f172a;">
            Assessment Fee: ₹4,999
        </div>
    </div>

    <button id="btn-trigger-payment" class="btn btn-primary">
        Proceed to Payment & Submit Application
    </button>

    <div id="payment-message" role="status" aria-live="polite"
         style="margin-top:15px; font-size:0.95rem;">
    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const paymentButton = document.getElementById('btn-trigger-payment');
    const paymentMessage = document.getElementById('payment-message');

    let applicationId = null;
    let paymentInProgress = false;

    const applicationUrl = <?= json_encode(base_url('api/applications')) ?>;
    const createOrderUrl = <?= json_encode(base_url('api/payment/create-order')) ?>;
    const verifyPaymentUrl = <?= json_encode(base_url('api/payment/verify')) ?>;

    function showMessage(message, success = false) {
        paymentMessage.textContent = message;
        paymentMessage.style.color = success ? '#15803d' : '#dc2626';
    }

    async function readResponse(response) {
        const data = await response.json();

        if (!response.ok || data.status === false) {
            throw new Error(data.message || 'Something went wrong.');
        }

        return data;
    }

    paymentButton.addEventListener('click', async function () {

        if (paymentInProgress) {
            return;
        }

        paymentInProgress = true;
        paymentButton.disabled = true;
        paymentButton.textContent = 'Please wait...';
        showMessage('Preparing your application and payment...');

        try {

            // STEP 1: Create application only once.
            if (!applicationId) {

                const applicationResponse = await fetch(applicationUrl, {
                    method: 'POST',
                    credentials: 'same-origin',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams({
                        assessment_type: 'Full CREDENCE Tech Due-Diligence & Trust Score Assessment'
                    })
                });

                const applicationData = await readResponse(applicationResponse);

                if (!applicationData.application || !applicationData.application.id) {
                    throw new Error('Application ID was not received.');
                }

                applicationId = applicationData.application.id;
            }

            // STEP 2: Create Razorpay order.
            const orderResponse = await fetch(createOrderUrl, {
                method: 'POST',
                credentials: 'same-origin',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    application_id: applicationId
                })
            });

            const orderData = await readResponse(orderResponse);

            // STEP 3: Check Razorpay Checkout availability.
            if (typeof Razorpay === 'undefined') {
                throw new Error('Razorpay Checkout could not be loaded. Please refresh the page.');
            }

            // STEP 4: Open Razorpay Checkout.
            const options = {
                key: orderData.key_id,
                amount: orderData.amount,
                currency: orderData.currency,
                name: 'CREDENCE',
                description: 'Tech Due-Diligence Assessment',
                order_id: orderData.order_id,

                handler: async function (paymentResponse) {

                    showMessage('Payment received. Verifying payment...');

                    try {

                        // STEP 5: Verify payment on backend.
                        const verifyResponse = await fetch(verifyPaymentUrl, {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json'
                            },
                            body: JSON.stringify({
                                application_id: applicationId,
                                razorpay_order_id: paymentResponse.razorpay_order_id,
                                razorpay_payment_id: paymentResponse.razorpay_payment_id,
                                razorpay_signature: paymentResponse.razorpay_signature
                            })
                        });

                        const verifyData = await readResponse(verifyResponse);

                        showMessage(
                            'Payment successful! Your CREDENCE application has been submitted. Application ID: ' + applicationId,
                            true
                        );

                        paymentButton.textContent = 'Payment Completed';
                        paymentButton.disabled = true;

                    } catch (error) {

                        showMessage(
                            'Payment verification failed: ' + error.message +
                            ' Please contact the administrator with your payment ID.'
                        );

                        paymentButton.disabled = false;
                        paymentButton.textContent = 'Retry Payment';
                        paymentInProgress = false;
                    }
                },

                modal: {
                    ondismiss: function () {
                        showMessage('Payment window closed. You can retry payment.');
                        paymentButton.disabled = false;
                        paymentButton.textContent = 'Retry Payment';
                        paymentInProgress = false;
                    }
                },

                theme: {
                    color: '#2563eb'
                }
            };

            const razorpay = new Razorpay(options);

            razorpay.on('payment.failed', function (response) {
                showMessage(
                    'Payment failed: ' +
                    (response.error.description || 'Please try again.')
                );

                paymentButton.disabled = false;
                paymentButton.textContent = 'Retry Payment';
                paymentInProgress = false;
            });

            razorpay.open();

        } catch (error) {

            showMessage(error.message);

            paymentButton.disabled = false;
            paymentButton.textContent = 'Retry Payment';
            paymentInProgress = false;
        }
    });
});
</script>

<?php echo view('layouts/dashboard-footer'); ?>