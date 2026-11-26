<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Razorpay\Api\Api;

class PaymentController extends Controller
{
    private $keyId;
    private $keySecret;
    private $amount = 499900; // ₹4999 = 499900 paise

    public function __construct()
    {
        $this->keyId = env('razorpay.keyId');
        $this->keySecret = env('razorpay.keySecret');
    }

    // =====================================
    // 1. CREATE RAZORPAY ORDER
    // =====================================

    public function createOrder()
    {
        if (
            !session()->get('logged_in') ||
            session()->get('role') !== 'Company'
        ) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login as Company.'
                ]);
        }

        $data = $this->request->getJSON(true);

        $applicationId = $data['application_id'] ?? null;

        if (!$applicationId) {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status' => false,
                    'message' => 'Application ID is required.'
                ]);
        }

        if (!$this->keyId || !$this->keySecret) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => false,
                    'message' => 'Razorpay keys are not configured.'
                ]);
        }

        $db = \Config\Database::connect();

        // Check application ownership
        $application = $db->table('assessment_applications')
            ->where('id', $applicationId)
            ->where('user_id', session()->get('user_id'))
            ->get()
            ->getRowArray();

        if (!$application) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Application not found.'
                ]);
        }

        // Check existing payment
        if ($application['payment_status'] === 'Paid') {
            return $this->response
                ->setJSON([
                    'status' => false,
                    'message' => 'Payment is already completed.'
                ]);
        }

        try {

            $api = new Api(
                $this->keyId,
                $this->keySecret
            );

            // Create Razorpay order
            $order = $api->order->create([
                'receipt' => $application['application_number'],
                'amount' => $this->amount,
                'currency' => 'INR',
                'notes' => [
                    'application_id' => $applicationId
                ]
            ]);

            // Save order details
            $db->table('assessment_applications')
                ->where('id', $applicationId)
                ->update([
                    'razorpay_order_id' => $order['id'],
                    'payment_amount' => 4999.00,
                    'payment_currency' => 'INR',
                    'payment_status' => 'Pending'
                ]);

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Payment order created successfully.',
                'key_id' => $this->keyId,
                'order_id' => $order['id'],
                'amount' => $this->amount,
                'currency' => 'INR',
                'application_id' => $applicationId
            ]);

        } catch (\Throwable $e) {

            log_message('error', 'Razorpay Order Error: ' . $e->getMessage());

            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => false,
                    'message' => 'Unable to create payment order.'
                ]);
        }
    }


    // =====================================
    // 2. VERIFY RAZORPAY PAYMENT
    // =====================================

   public function verifyPayment()
{
    if (
        !session()->get('logged_in') ||
        session()->get('role') !== 'Company'
    ) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
    }

    if (!$this->keyId || !$this->keySecret) {
        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'status' => false,
                'message' => 'Razorpay keys are not configured.'
            ]);
    }

    $data = $this->request->getJSON(true);

    $applicationId = $data['application_id'] ?? null;
    $orderId = $data['razorpay_order_id'] ?? null;
    $paymentId = $data['razorpay_payment_id'] ?? null;
    $signature = $data['razorpay_signature'] ?? null;

    if (
        !$applicationId ||
        !$orderId ||
        !$paymentId ||
        !$signature
    ) {
        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status' => false,
                'message' => 'Payment details are incomplete.'
            ]);
    }

    $db = \Config\Database::connect();

    $application = $db->table('assessment_applications')
        ->where('id', $applicationId)
        ->where('user_id', session()->get('user_id'))
        ->where('razorpay_order_id', $orderId)
        ->get()
        ->getRowArray();

    if (!$application) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'status' => false,
                'message' => 'Invalid application or order.'
            ]);
    }

    if ($application['payment_status'] === 'Paid') {
        return $this->response->setJSON([
            'status' => true,
            'message' => 'Payment is already verified.',
            'payment_status' => 'Paid'
        ]);
    }

    try {

        $api = new Api(
            $this->keyId,
            $this->keySecret
        );

        // Step 1: Verify Razorpay signature
        $api->utility->verifyPaymentSignature([
            'razorpay_order_id' => $orderId,
            'razorpay_payment_id' => $paymentId,
            'razorpay_signature' => $signature
        ]);

        // Step 2: Fetch actual payment details from Razorpay
        $payment = $api->payment->fetch($paymentId);

        // Step 3: Verify order ID
        if ($payment['order_id'] !== $orderId) {
            throw new \RuntimeException('Order ID mismatch.');
        }

        // Step 4: Verify amount
        $expectedAmount = (int) round(
            (float) $application['payment_amount'] * 100
        );

        if ((int) $payment['amount'] !== $expectedAmount) {
            throw new \RuntimeException('Payment amount mismatch.');
        }

        // Step 5: Verify currency
        if (
            $payment['currency'] !==
            $application['payment_currency']
        ) {
            throw new \RuntimeException('Currency mismatch.');
        }

        // Step 6: Only captured payments are accepted
        if ($payment['status'] !== 'captured') {
            return $this->response
                ->setStatusCode(400)
                ->setJSON([
                    'status' => false,
                    'message' => 'Payment is not captured yet.',
                    'payment_status' => $payment['status']
                ]);
        }

        // Step 7: Update database only after successful verification
        $db->table('assessment_applications')
            ->where('id', $applicationId)
            ->where('user_id', session()->get('user_id'))
            ->where('razorpay_order_id', $orderId)
            ->where('payment_status', 'Pending')
            ->update([
                'razorpay_payment_id' => $paymentId,
                'razorpay_signature' => $signature,
                'payment_status' => 'Paid',
                'paid_at' => date('Y-m-d H:i:s')
            ]);

        // Confirm final database status
        $updatedApplication = $db->table('assessment_applications')
            ->select('payment_status')
            ->where('id', $applicationId)
            ->get()
            ->getRowArray();

        if (!$updatedApplication ||
            $updatedApplication['payment_status'] !== 'Paid'
        ) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'status' => false,
                    'message' => 'Payment status could not be updated.'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Payment verified successfully.',
            'payment_id' => $paymentId,
            'application_id' => $applicationId,
            'payment_status' => 'Paid'
        ]);

    } catch (\Throwable $e) {

        log_message(
            'error',
            'Payment Verification Error: ' . $e->getMessage()
        );

        return $this->response
            ->setStatusCode(400)
            ->setJSON([
                'status' => false,
                'message' => 'Payment verification failed.'
            ]);
    }
}


    // =====================================
    // 3. CHECK PAYMENT STATUS
    // =====================================

    public function paymentStatus($applicationId)
    {
        if (!session()->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        $db = \Config\Database::connect();

        $query = $db->table('assessment_applications')
            ->select('id, application_number, payment_status, payment_amount, payment_currency, paid_at')
            ->where('id', $applicationId);

        // Company can only see its own application
        if (session()->get('role') === 'Company') {
            $query->where('user_id', session()->get('user_id'));
        } elseif (session()->get('role') !== 'Admin') {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => false,
                    'message' => 'Access denied.'
                ]);
        }

        $application = $query->get()->getRowArray();

        if (!$application) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Application not found.'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'payment' => $application
        ]);
    }
}