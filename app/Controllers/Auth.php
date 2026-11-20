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
        $company = $companyModel->where('user_id', $userId)->first();

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
                'name', 'founder_details', 'contact_email', 'contact_phone',
                'website', 'industry', 'location', 'year_established',
                'team_size', 'company_description', 'problem_statement',
                'product_service', 'business_model', 'usp',
                'technology_used', 'intellectual_property'
            ];

            $completed = 0;
            foreach ($fields as $field) {
                if (!empty($company[$field])) {
                    $completed++;
                }
            }
            $data['profileCompletion'] = (int) round(($completed / count($fields)) * 100);

            if ($db->tableExists('documents')) {
                $documents = $db->table('documents')
                    ->where('user_id', $userId)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->getResultArray();

                $data['documents'] = $documents;
                $data['documentsCount'] = count($documents);
            }

            if ($db->tableExists('assessment_applications')) {
                $application = $db->table('assessment_applications')
                    ->where('user_id', $userId)
                    ->orderBy('id', 'DESC')
                    ->get()
                    ->getRowArray();

                if ($application) {
                    $data['applicationStatus'] = $application['status'] ?? 'Submitted';
                    $data['evaluationStatus'] = $application['status'] ?? 'Pending';
                    $data['workflowStage'] = 4;
                    $data['verificationStatus'] = ($application['status'] ?? '') === 'Certified' ? 'Verified' : 'Pending';
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

    public function documentsSave()
    {
        $this->setStepComplete('documents');

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Documents saved'
        ]);
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
    // PROFILE COMPLETE (wizard step)
    // =========================

    public function profileComplete()
    {
        $this->setStepComplete('profile');

        return $this->response->setJSON(['status' => true]);
    }

    // =========================
    // ADMIN
    // =========================

    public function adminDashboard()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to(base_url('login'));
        }

        return view('admin/dashboard');
    }

    public function adminParams()
    {
        if (!session()->get('logged_in') || session()->get('role') !== 'Admin') {
            return redirect()->to(base_url('login'));
        }

        return view('admin/params');
    }

    // =========================
    // EVALUATOR
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
    // PUBLIC VERIFY PAGE
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
        $verificationId = strtoupper(trim($this->request->getGet('id') ?? ''));

        if (empty($verificationId)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Verification ID is required.'
            ]);
        }

        $db = \Config\Database::connect();

        $certificate = $db->table('evaluations e')
            ->select('e.verification_id, e.total_score, e.certificate_issued_at, e.certificate_path,
                      a.application_number, a.assessment_type, a.status, c.name AS company_name')
            ->join('assessment_applications a', 'a.id = e.application_id')
            ->join('companies c', 'c.id = a.company_id')
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

    // =========================
    // WIZARD STEP HELPERS
    // =========================

    private function getStepStatus(): array
    {
        return session()->get('wizard_steps') ?? [
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

            return redirect()->to(base_url($prev))->with('error', 'Pehle is step ko complete karo.');
        }

        return null;
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
}