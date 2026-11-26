<?php

namespace App\Controllers;

class Auth extends BaseController
{
    // =========================
    // LOGIN
    // =========================

    public function login()
    {
        return view('auth/login');
    }

    // =========================
    // COMPANY DASHBOARD
    // =========================

    public function dashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $data = $this->userData();
        $userId = session()->get('user_id');

        $companyModel = new \App\Models\CompanyModel();

        $company = $companyModel
            ->where('user_id', $userId)
            ->first();

        $db = \Config\Database::connect();

        $data['companyName'] = $company['name'] ?? 'My Company';
        $data['profileCompletion'] = 0;
        $data['documentsCount'] = 0;
        $data['workflowStage'] = 2;
        $data['verificationStatus'] = 'Pending';
        $data['applicationStatus'] = 'Not Submitted';
        $data['evaluatorName'] = 'Not Assigned';
        $data['evaluationStatus'] = 'Pending';
        $data['finalScore'] = '-- / 100';
        $data['documents'] = [];
        // Payment Unlock Status
$data['isPaid'] = false;
$data['paymentStatus'] = 'Unpaid';

if ($db->tableExists('assessment_applications')) {

    $paidApplication = $db->table('assessment_applications')
        ->where('user_id', $userId)
        ->where('payment_status', 'Paid')
        ->orderBy('id', 'DESC')
        ->get()
        ->getRowArray();

    if ($paidApplication) {
        $data['isPaid'] = true;
        $data['paymentStatus'] = 'Paid';
    }
}

        if ($company) {

            $fields = [
                'name',
                'founder_details',
                'contact_email',
                'contact_phone',
                'website',
                'industry',
                'location',
                'year_established',
                'team_size',
                'company_description',
                'problem_statement',
                'product_service',
                'business_model',
                'usp',
                'technology_used',
                'intellectual_property'
            ];

            $completed = 0;

            foreach ($fields as $field) {
                if (!empty($company[$field])) {
                    $completed++;
                }
            }

            $data['profileCompletion'] = (int) round(
                ($completed / count($fields)) * 100
            );

            // Documents
            if ($db->tableExists('documents')) {

                $documents = $db->table('documents')
                    ->where('user_id', $userId)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->getResultArray();

                $data['documents'] = $documents;
                $data['documentsCount'] = count($documents);
            }

            // Assessment Application
            if ($db->tableExists('assessment_applications')) {

                $application = $db->table('assessment_applications')
                    ->where('user_id', $userId)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->getRowArray();

                if ($application) {

                    $data['applicationStatus'] =
                        $application['status'] ?? 'Submitted';

                    $data['evaluationStatus'] =
                        $application['status'] ?? 'Pending';

                    $data['workflowStage'] = 4;

                    $data['verificationStatus'] =
                        ($application['status'] ?? '') === 'Certified'
                            ? 'Verified'
                            : 'Pending';
                }
            }
        }

        return view('dashboard/startup', $data);
    }
    // Evaluator Assignment Page
public function evaluatorAssignment()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }

    $data = $this->userData();

    $userId = (int) session()->get('user_id');
    $db = \Config\Database::connect();

    $data['isPaid'] = false;
    $data['paymentStatus'] = 'Unpaid';
    $data['evaluatorName'] = 'Not Assigned Yet';
    $data['assignmentStatus'] = 'Pending';
    $data['assignmentDate'] = null;
    $data['applicationNumber'] = null;

    // Fetch latest application of logged-in company
    $application = $db->table('assessment_applications')
        ->where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->get()
        ->getRowArray();

    if ($application) {

        $data['paymentStatus'] =
            $application['payment_status'] ?? 'Unpaid';

        $data['isPaid'] =
            strtolower((string) $data['paymentStatus']) === 'paid';

        $data['applicationNumber'] =
            $application['application_number'] ?? null;

        // Fetch actual evaluator assignment
        $assignment = $db->table('application_assignments')
            ->where('application_id', $application['id'])
            ->get()
            ->getRowArray();

        if ($assignment) {

            $data['evaluatorName'] =
                $assignment['assigned_evaluator_name'] ?: 'Not Assigned Yet';

            $data['assignmentStatus'] =
                $assignment['status'] ?? 'Pending';

            $data['assignmentDate'] =
                $assignment['assigned_at'] ?? null;
        }
    }

    return view('dashboard/evaluator_assignment', $data);
}
// Evaluation & Scoring Page
public function evaluationScoring()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }

    $data = $this->userData();

    $userId = (int) session()->get('user_id');
    $db = \Config\Database::connect();

    $data['isPaid'] = false;
    $data['paymentStatus'] = 'Unpaid';
    $data['evaluatorName'] = 'Not Assigned Yet';
    $data['evaluationStatus'] = 'Not Started';
    $data['finalScore'] = '-- / 100';
    $data['evaluationParameters'] = [];
    $data['applicationNumber'] = null;
    $data['evaluationComments'] = null;

    // Fetch latest application
    $application = $db->table('assessment_applications')
        ->where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->get()
        ->getRowArray();

    if ($application) {

        $data['paymentStatus'] =
            $application['payment_status'] ?? 'Unpaid';

        $data['isPaid'] =
            strtolower((string) $data['paymentStatus']) === 'paid';

        $data['applicationNumber'] =
            $application['application_number'] ?? null;

        // Fetch assigned display name
        $assignment = $db->table('application_assignments')
            ->where('application_id', $application['id'])
            ->get()
            ->getRowArray();

        if ($assignment) {
            $data['evaluatorName'] =
                $assignment['assigned_evaluator_name'] ?: 'Not Assigned Yet';
        }

        // Fetch evaluation record
        $evaluation = $db->table('evaluations')
            ->where('application_id', $application['id'])
            ->get()
            ->getRowArray();

        $scoreMap = [];

        if ($evaluation) {

            $data['evaluationStatus'] =
                $evaluation['status'] ?? 'Submitted';

            $data['finalScore'] =
                number_format((float) $evaluation['total_score'], 2) . ' / 100';

            $data['evaluationComments'] =
                $evaluation['comments'] ?? null;

            // Fetch actual parameter scores
            $scores = $db->table('evaluation_scores')
                ->where('evaluation_id', $evaluation['id'])
                ->get()
                ->getResultArray();

            foreach ($scores as $score) {
                $scoreMap[(int) $score['parameter_id']] = $score;
            }
        }

        // Fetch all active evaluation parameters
        $parameters = $db->table('evaluation_parameters')
            ->where('is_active', 1)
            ->orderBy('id', 'ASC')
            ->get()
            ->getResultArray();

        foreach ($parameters as $parameter) {

            $parameterId = (int) $parameter['id'];
            $savedScore = $scoreMap[$parameterId] ?? null;

            $data['evaluationParameters'][] = [
                'parameter_name' => $parameter['parameter_name'],
                'weight' => $parameter['weight'],
                'score' => $savedScore['score'] ?? null,
                'weighted_score' => $savedScore['weighted_score'] ?? null
            ];
        }
    }

    return view('dashboard/evaluation_scoring', $data);
}
// =========================
// CREDENCE REVIEW PAGE
// =========================

public function credenceReview()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }

    $data = $this->userData();

    $userId = (int) session()->get('user_id');
    $db = \Config\Database::connect();

    $data['isPaid'] = false;
    $data['paymentStatus'] = 'Unpaid';
    $data['reviewStatus'] = 'Not Started';
    $data['evaluationStatus'] = 'Not Started';
    $data['finalDecision'] = 'Awaiting';
    $data['adminRemarks'] = 'Awaiting Review';
    $data['reviewDate'] = null;
    $data['finalScore'] = '-- / 100';
    $data['applicationNumber'] = null;

    // Latest application of logged-in company
    $application = $db->table('assessment_applications')
        ->where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->get()
        ->getRowArray();

    if ($application) {

        $data['paymentStatus'] =
            $application['payment_status'] ?? 'Unpaid';

        $data['isPaid'] =
            strtolower((string) $data['paymentStatus']) === 'paid';

        $data['applicationNumber'] =
            $application['application_number'] ?? null;

        // Fetch actual evaluation
        $evaluation = $db->table('evaluations')
            ->where('application_id', $application['id'])
            ->get()
            ->getRowArray();

        if ($evaluation) {

            $data['evaluationStatus'] =
                $evaluation['status'] ?? 'Submitted';

            $data['finalScore'] =
                number_format((float) $evaluation['total_score'], 2) . ' / 100';

            $data['adminRemarks'] =
                !empty($evaluation['admin_remarks'])
                    ? $evaluation['admin_remarks']
                    : 'No review remarks provided yet.';

            $data['reviewDate'] =
                $evaluation['reviewed_at'] ?? null;

            $status = strtolower((string) ($evaluation['status'] ?? ''));

            if ($status === 'approved') {
                $data['reviewStatus'] = 'Completed';
                $data['finalDecision'] = 'Approved';
            } elseif ($status === 'rejected') {
                $data['reviewStatus'] = 'Completed';
                $data['finalDecision'] = 'Rejected';
            } else {
                $data['reviewStatus'] = 'In Progress';
                $data['finalDecision'] = 'Awaiting';
            }
        }
    }

    return view('dashboard/credence_review', $data);
}
public function certificateVerification()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }

    $data = $this->userData();

    $userId = (int) session()->get('user_id');
    $db = \Config\Database::connect();

    // Default values
    $data['isPaid'] = false;
    $data['paymentStatus'] = 'Unpaid';

    $data['certificateStatus'] = 'Not Issued';
    $data['verificationStatus'] = 'Not Issued';
    $data['qrStatus'] = 'Not Available';

    $data['verificationId'] = null;
    $data['finalScore'] = '-- / 100';
    $data['approvalStatus'] = 'Awaiting';
    $data['issueDate'] = null;

    $data['downloadUrl'] = null;
    $data['verificationUrl'] = base_url('verify');

    $data['qrImageData'] = null;
    $data['isCertificateGenerated'] = false;

    // Fetch latest company application
    $application = $db->table('assessment_applications')
        ->where('user_id', $userId)
        ->orderBy('id', 'DESC')
        ->get()
        ->getRowArray();

    if ($application) {

        $data['paymentStatus'] =
            $application['payment_status'] ?? 'Unpaid';

        $data['isPaid'] =
            strtolower((string) $data['paymentStatus']) === 'paid';

        // Fetch evaluation
        $evaluation = $db->table('evaluations')
            ->where('application_id', $application['id'])
            ->get()
            ->getRowArray();

        if ($evaluation) {

            $verificationId = $evaluation['verification_id'] ?? null;

            $data['verificationId'] = $verificationId;

            $data['finalScore'] =
                number_format((float) ($evaluation['total_score'] ?? 0), 2)
                . ' / 100';

            $data['approvalStatus'] =
                $evaluation['status'] ?? 'Pending';

            $data['issueDate'] =
                $evaluation['certificate_issued_at'] ?? null;

            if (!empty($verificationId)) {

                $data['verificationUrl'] =
                    site_url('verify') . '?id=' . urlencode($verificationId);

                $safeId = preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '',
                    $verificationId
                );

                // Check actual PDF file
                $pdfPath = WRITEPATH
                    . 'uploads/certificates/certificate_'
                    . $safeId
                    . '.pdf';

                // Check actual QR image
                $qrPath = WRITEPATH
                    . 'uploads/certificates/qr_'
                    . $safeId
                    . '.png';

                $pdfExists = is_file($pdfPath);
                $qrExists = is_file($qrPath);

                $isApproved =
                    strtolower((string) $data['approvalStatus']) === 'approved';

                if (
                    $isApproved &&
                    $data['isPaid'] &&
                    !empty($data['issueDate']) &&
                    !empty($evaluation['certificate_path']) &&
                    $pdfExists
                ) {
                    $data['isCertificateGenerated'] = true;

                    $data['certificateStatus'] = 'Generated';
                    $data['verificationStatus'] = 'Valid';

                    $data['downloadUrl'] = base_url(
                        'api/certificate/download/' . urlencode($verificationId)
                    );

                    if ($qrExists) {
                        $data['qrStatus'] = 'Available';

                        $data['qrImageData'] = 'data:image/png;base64,'
                            . base64_encode(file_get_contents($qrPath));
                    }
                } elseif (!$isApproved) {

                    $data['certificateStatus'] = 'Awaiting Approval';
                    $data['verificationStatus'] = 'Not Issued';

                } else {

                    $data['certificateStatus'] = 'Pending Generation';
                    $data['verificationStatus'] = 'Not Issued';
                }
            }
        }
    }

    return view('dashboard/certificate_verification', $data);
}
    

    // =========================
    // COMPANY PROFILE
    // =========================

    public function profile()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        return view('dashboard/profile', $this->userData());
    }

    // =========================
    // DOCUMENTS
    // =========================

    public function documents()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        if ($redirect = $this->guardStep('documents')) {
            return $redirect;
        }

        return view('dashboard/documents', $this->userData());
    }

    // =========================
    // APPLY
    // =========================

    public function apply()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        if ($redirect = $this->guardStep('apply')) {
            return $redirect;
        }

        return view('dashboard/apply', $this->userData());
    }

    // =========================
    // ADMIN DASHBOARD
    // =========================

    public function adminDashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        if (session()->get('role') !== 'Admin') {
            return redirect()->to(base_url('login'));
        }

        return view('admin/dashboard');
    }

    // =========================
    // ADMIN PARAMETERS
    // =========================

    public function adminParams()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        if (session()->get('role') !== 'Admin') {
            return redirect()->to(base_url('login'));
        }

        return view('admin/params');
    }

    // =========================
    // EVALUATOR DASHBOARD
    // =========================

    public function evalDashboard()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $role = session()->get('role');

        if ($role !== 'Evaluator' && $role !== 'Admin') {
            return redirect()->to(base_url('login'));
        }

        return view('evaluator/dashboard', $this->userData());
    }

    // =========================
    // WIZARD STEP MANAGEMENT
    // =========================

    private function getStepStatus(): array
    {
        $session = session();

        return $session->get('wizard_steps') ?? [
            'profile' => 'active',
            'documents' => 'locked',
            'apply' => 'locked',
        ];
    }

    private function setStepComplete(string $step): void
    {
        $steps = $this->getStepStatus();

        $steps[$step] = 'completed';

        $order = ['profile', 'documents', 'apply'];

        $idx = array_search($step, $order);

        if ($idx !== false && isset($order[$idx + 1])) {
            $steps[$order[$idx + 1]] = 'active';
        }

        session()->set('wizard_steps', $steps);
    }

    private function guardStep(string $step)
    {
        $steps = $this->getStepStatus();

        if (($steps[$step] ?? 'locked') === 'locked') {

            $order = ['profile', 'documents', 'apply'];

            $idx = array_search($step, $order);

            $prev = $order[$idx - 1] ?? 'profile';

            return redirect()
                ->to(base_url($prev))
                ->with('error', 'Pehle is step ko complete karo.');
        }

        return null;
    }

    // =========================
    // DOCUMENT SAVE
    // =========================

    public function documentsSave()
    {
        $this->setStepComplete('documents');

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Documents saved'
        ]);
    }

    // =========================
    // COMPANY PROFILE SAVE
    // =========================

    public function profileSave()
    {
        $session = session();

        if (!$session->get('logged_in') || !$session->get('user_id')) {

            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        $userId = $session->get('user_id');

        $companyModel = new \App\Models\CompanyModel();

        $company = $companyModel
            ->where('user_id', $userId)
            ->first();

        $data = [
            'name' => $this->request->getPost('companyName'),
            'founder_details' => $this->request->getPost('founderDetails'),
            'contact_email' => $this->request->getPost('contactEmail'),
            'contact_phone' => $this->request->getPost('contactPhone'),
            'website' => $this->request->getPost('website'),
            'location' => $this->request->getPost('location'),
            'industry' => $this->request->getPost('industry'),
            'year_established' => $this->request->getPost('yearEstablished'),
            'team_size' => $this->request->getPost('teamSize'),
            'company_description' => $this->request->getPost('companyDescription'),
            'problem_statement' => $this->request->getPost('problemStatement'),
            'product_service' => $this->request->getPost('productService'),
            'business_model' => $this->request->getPost('businessModel'),
            'usp' => $this->request->getPost('usp'),
            'technology_used' => $this->request->getPost('technologyUsed'),
            'intellectual_property' => $this->request->getPost('intellectualProperty'),
        ];

        if ($company) {

            if (!$companyModel->update($company['id'], $data)) {

                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Profile update failed.',
                        'errors' => $companyModel->errors()
                    ]);
            }

        } else {

            $data['user_id'] = $userId;

            if (!$companyModel->insert($data)) {

                return $this->response
                    ->setStatusCode(500)
                    ->setJSON([
                        'status' => false,
                        'message' => 'Profile save failed.',
                        'errors' => $companyModel->errors()
                    ]);
            }
        }

        $this->setStepComplete('profile');

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Company profile saved successfully.'
        ]);
    }
    

    // =========================
    // USER DATA
    // =========================

    private function userData(): array
    {
        $name = session()->get('name') ?? 'User';

        $parts = preg_split('/\s+/', trim($name));

        $initials = strtoupper(
            substr($parts[0] ?? '', 0, 1) .
            (isset($parts[1]) ? substr($parts[1], 0, 1) : '')
        );

        return [
            'userName' => $name,
            'userInitials' => $initials ?: 'U',
        ];
    }
    

    // =========================
    // PUBLIC CERTIFICATE PAGE
    // =========================

    public function verify()
    {
        return view('public/verify');
    }

    // =========================
    // CERTIFICATE VERIFICATION API
    // =========================

    public function verifyCertificate()
    {
        $verificationId = strtoupper(trim(
            $this->request->getGet('id') ?? ''
        ));

        if (empty($verificationId)) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Verification ID is required.'
            ]);
        }

        $db = \Config\Database::connect();

        $certificate = $db->table('evaluations e')
            ->select('
                e.verification_id,
                e.total_score,
                e.certificate_issued_at,
                e.certificate_path,
                a.application_number,
                a.assessment_type,
                a.status,
                c.name AS company_name
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

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Invalid or unapproved certificate.'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Certificate verified successfully.',
            'certificate' => $certificate
        ]);
    }

}