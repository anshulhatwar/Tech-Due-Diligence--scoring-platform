<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use Dompdf\Dompdf;
use Dompdf\Options;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;

class CertificateController extends Controller
{
    // ==========================================
    // GENERATE AND DOWNLOAD CERTIFICATE
    // ==========================================

    public function generate($verificationId)
    {
        // Admin authentication
        if (
            !session()->get('logged_in') ||
            session()->get('role') !== 'Admin'
        ) {
            return redirect()->to('/login');
        }

        $db = \Config\Database::connect();

        // Fetch approved evaluation
        $certificate = $db->table('evaluations e')
            ->select('
                e.id,
                e.total_score,
                e.verification_id,
                e.certificate_issued_at,
                e.certificate_path,
                a.application_number,
                a.assessment_type,
                c.name AS company_name,
                c.industry
            ')
            ->join(
                'assessment_applications a',
                'a.id = e.application_id'
            )
            ->join(
                'companies c',
                'c.id = a.company_id'
            )
            ->where('e.verification_id', $verificationId)
            ->where('e.status', 'Approved')
            ->get()
            ->getRowArray();

        if (!$certificate) {
            return redirect()->back()
                ->with('error', 'Approved certificate not found.');
        }

        // Certificate storage folder
        $folder = WRITEPATH . 'uploads/certificates/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        $safeId = preg_replace(
            '/[^A-Z0-9-]/',
            '',
            strtoupper($verificationId)
        );

        $pdfPath = $folder . 'certificate_' . $safeId . '.pdf';
        $qrPath = $folder . 'qr_' . $safeId . '.png';

        // Public verification URL
        $verificationUrl = site_url('verify')
            . '?id=' . urlencode($verificationId);

        // Generate QR Code
        $qrCode = new QrCode(
            $verificationUrl,
            new Encoding('UTF-8'),
            ErrorCorrectionLevel::High,
            300,
            10,
            RoundBlockSizeMode::Margin
        );

        $writer = new PngWriter();

        $qrResult = $writer->write($qrCode);

        $qrResult->saveToFile($qrPath);

        $qrBase64 = base64_encode(
            file_get_contents($qrPath)
        );

        // Certificate issue date
        $issueDate = !empty($certificate['certificate_issued_at'])
            ? date(
                'd F Y',
                strtotime($certificate['certificate_issued_at'])
            )
            : date('d F Y');

        // Certificate HTML
        $html = '
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset="UTF-8">

            <style>
                body {
                    font-family: DejaVu Sans, sans-serif;
                    text-align: center;
                    color: #172554;
                }

                .certificate {
                    border: 10px double #2563eb;
                    padding: 35px;
                    height: 850px;
                }

                h1 {
                    font-size: 36px;
                    color: #1d4ed8;
                    margin-top: 35px;
                }

                h2 {
                    font-size: 23px;
                }

                .company {
                    font-size: 28px;
                    font-weight: bold;
                    margin: 25px;
                    color: #111827;
                }

                .score {
                    font-size: 24px;
                    color: #15803d;
                    font-weight: bold;
                }

                .details {
                    font-size: 14px;
                    line-height: 2;
                }

                .qr {
                    margin-top: 20px;
                }

                .footer {
                    margin-top: 25px;
                    font-size: 12px;
                }
            </style>
        </head>

        <body>

            <div class="certificate">

                <h1>CREDENCE</h1>

                <h2>TECH DUE-DILIGENCE CERTIFICATE</h2>

                <p>This certificate is proudly awarded to</p>

                <div class="company">
                    ' . esc($certificate['company_name']) . '
                </div>

                <p>
                    For successfully completing the
                    technology due-diligence assessment.
                </p>

                <p class="score">
                    Trust Score:
                    ' . number_format(
                        (float) $certificate['total_score'],
                        2
                    ) . ' / 100
                </p>

                <div class="details">

                    <p>
                        Application Number:
                        ' . esc($certificate['application_number']) . '
                    </p>

                    <p>
                        Assessment Type:
                        ' . esc($certificate['assessment_type']) . '
                    </p>

                    <p>
                        Industry:
                        ' . esc($certificate['industry']) . '
                    </p>

                    <p>
                        Verification ID:
                        ' . esc($verificationId) . '
                    </p>

                    <p>
                        Issue Date:
                        ' . $issueDate . '
                    </p>

                    <p>Status: APPROVED</p>

                </div>

                <div class="qr">

                    <img
                        src="data:image/png;base64,' . $qrBase64 . '"
                        width="130"
                    >

                    <p>Scan QR Code to verify certificate</p>

                </div>

                <div class="footer">
                    CREDENCE |
                    Technology Due-Diligence & Trust Score Platform
                </div>

            </div>

        </body>
        </html>';

        // Generate PDF
        $options = new Options();

        $options->set('isRemoteEnabled', false);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);

        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        // Save PDF
        file_put_contents(
            $pdfPath,
            $dompdf->output()
        );

        // Update database
        $db->table('evaluations')
            ->where('verification_id', $verificationId)
            ->update([
                'certificate_issued_at' => date('Y-m-d H:i:s'),
                'certificate_path' =>
                    'uploads/certificates/certificate_' . $safeId . '.pdf'
            ]);

        // Download certificate
        return $this->response->download(
            $pdfPath,
            null
        );
    }


    // ==========================================
    // DOWNLOAD EXISTING CERTIFICATE
    // ==========================================

    public function download($verificationId)
    {
        // Check login
        if (!session()->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        $db = \Config\Database::connect();

        // Find approved certificate
        $certificate = $db->table('evaluations e')
            ->select('
                e.verification_id,
                e.certificate_path,
                e.status,
                a.user_id
            ')
            ->join(
                'assessment_applications a',
                'a.id = e.application_id'
            )
            ->where('e.verification_id', $verificationId)
            ->where('e.status', 'Approved')
            ->get()
            ->getRowArray();

        if (!$certificate) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Certificate not found.'
                ]);
        }

        // Check user permission
        $role = session()->get('role');
        $userId = session()->get('user_id');

        if (
            $role !== 'Admin' &&
            !(
                $role === 'Company' &&
                (int) $certificate['user_id'] === (int) $userId
            )
        ) {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => false,
                    'message' => 'You are not authorized to download this certificate.'
                ]);
        }

        // Check PDF path
        if (empty($certificate['certificate_path'])) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Certificate has not been generated yet.'
                ]);
        }

        $filePath = WRITEPATH . $certificate['certificate_path'];

        if (!is_file($filePath)) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Certificate PDF file does not exist.'
                ]);
        }

        // Download PDF
        return $this->response->download(
            $filePath,
            null
        );
    }
}
