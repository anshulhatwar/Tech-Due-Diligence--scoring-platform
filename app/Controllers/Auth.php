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