<?php

namespace App\Controllers\Application;

use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\CompanyModel;
use App\Models\AssignmentModel;

class ApplicationController extends BaseController
{
    // Submit a new assessment application
    public function create()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        $userId = $session->get('user_id');

        $assessmentType = trim(
            (string) $this->request->getPost('assessment_type')
        );

        if ($assessmentType === '' || strlen($assessmentType) > 100) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'message' => 'A valid assessment_type is required.'
                ]);
        }

        // Find logged-in user's company
        $companyModel = new CompanyModel();

        $company = $companyModel
            ->where('user_id', $userId)
            ->first();

        if (!$company) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please complete your company profile first.'
                ]);
        }

        $applicationModel = new ApplicationModel();

        // Generate unique application number
        do {
            $applicationNumber = 'CRD-' . strtoupper(bin2hex(random_bytes(6)));

        } while (
            $applicationModel
                ->where('application_number', $applicationNumber)
                ->first()
        );

        $data = [
            'user_id' => $userId,
            'company_id' => $company['id'],
            'application_number' => $applicationNumber,
            'assessment_type' => $assessmentType,
            'status' => 'Submitted',
            'payment_status' => 'Pending',
            'submitted_at' => date('Y-m-d H:i:s')
        ];

        if (!$applicationModel->insert($data)) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => false,
                    'message' => 'Failed to submit assessment application.',
                    'errors' => $applicationModel->errors(),
                    'database_error' => $applicationModel->db->error()
                ]);
        }

        return $this->response
            ->setStatusCode(201)
            ->setJSON([
                'status' => true,
                'message' => 'Assessment application submitted successfully.',
                'application' => [
                    'id' => $applicationModel->getInsertID(),
                    'application_number' => $applicationNumber,
                    'assessment_type' => $assessmentType,
                    'status' => 'Submitted',
                    'payment_status' => 'Pending'
                ]
            ]);
    }


    // List applications belonging to logged-in user
    public function index()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        $userId = $session->get('user_id');

        $applicationModel = new ApplicationModel();

        $applications = $applicationModel
            ->where('user_id', $userId)
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'total' => count($applications),
            'applications' => $applications
        ]);
    }


    // Show one application belonging to logged-in user
    public function show($id)
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        $userId = $session->get('user_id');

        $applicationModel = new ApplicationModel();

        $application = $applicationModel
            ->where('id', $id)
            ->where('user_id', $userId)
            ->first();

        if (!$application) {
            return $this->response
                ->setStatusCode(404)
                ->setJSON([
                    'status' => false,
                    'message' => 'Assessment application not found.'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'application' => $application
        ]);
    }


    // List all applications for Admin dashboard
    public function adminIndex()
{
    $session = session();

    if (!$session->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
    }

    if ($session->get('role') !== 'Admin') {
        return $this->response
            ->setStatusCode(403)
            ->setJSON([
                'status' => false,
                'message' => 'Admin access required.'
            ]);
    }

    $db = \Config\Database::connect();

    $applications = $db->table('assessment_applications a')
    ->select('
        a.id,
        a.company_id,
        a.application_number,
        a.assessment_type,
        a.status,
        a.payment_status,
        a.created_at,
        c.name AS company_name,
        aa.assigned_evaluator_name AS assigned_evaluator,
        aa.status AS assignment_status,
        e.total_score AS overall_score,
e.status AS evaluation_status,
e.verification_id,
e.certificate_issued_at,
e.certificate_path
    ')
    ->join('companies c', 'c.id = a.company_id', 'left')
    ->join(
        'application_assignments aa',
        'aa.application_id = a.id',
        'left'
    )
    ->join('evaluations e', 'e.application_id = a.id', 'left')
    ->orderBy('a.created_at', 'DESC')
    ->get()
    ->getResultArray();
    // Calculate total received assessment revenue
$revenueData = $db->table('assessment_applications')
    ->selectSum('payment_amount', 'total_revenue')
    ->where('payment_status', 'Paid')
    ->get()
    ->getRowArray();

$totalRevenue = (float) ($revenueData['total_revenue'] ?? 0);
    $underReview = 0;

    foreach ($applications as $application) {
        if (
            in_array(
                strtolower($application['status'] ?? ''),
                ['under review', 'in review', 'under_review'],
                true
            )
        ) {
            $underReview++;
        }
    }

    return $this->response->setJSON([
        'status' => true,
        'total' => count($applications),
        'under_review' => $underReview,
        'total_revenue' => $totalRevenue,
        'applications' => $applications
    ]);
}


    // Get available evaluators for Admin
    // Get Credence team display names for Admin assignment
public function evaluators()
{
    $session = session();

    if (!$session->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
    }

    if ($session->get('role') !== 'Admin') {
        return $this->response
            ->setStatusCode(403)
            ->setJSON([
                'status' => false,
                'message' => 'Admin access required.'
            ]);
    }

    return $this->response->setJSON([
        'status' => true,
        'evaluators' => [
            ['name' => 'Anshul'],
            ['name' => 'Madhur'],
            ['name' => 'Aryan']
        ]
    ]);
}


    // Assign application to an Evaluator
   // Assign application to a Credence team member
public function assignEvaluator()
{
    $session = session();

    if (!$session->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'message' => 'Please login first.'
            ]);
    }

    if ($session->get('role') !== 'Admin') {
        return $this->response
            ->setStatusCode(403)
            ->setJSON([
                'status' => false,
                'message' => 'Admin access required.'
            ]);
    }

    $applicationId = (int) $this->request->getPost('application_id');
    $evaluatorName = trim(
        (string) $this->request->getPost('evaluator_name')
    );

    $allowedNames = ['Anshul', 'Madhur', 'Aryan'];

    if (
        $applicationId <= 0 ||
        !in_array($evaluatorName, $allowedNames, true)
    ) {
        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'status' => false,
                'message' => 'Select a valid application and team member.'
            ]);
    }

    $db = \Config\Database::connect();

    // Verify application exists
    $application = $db->table('assessment_applications')
        ->where('id', $applicationId)
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

    // Admin ID is used internally to satisfy the evaluator_id foreign key.
    $adminId = (int) $session->get('user_id');

    $admin = $db->table('users')
        ->where('ID', $adminId)
        ->where('Role', 'Admin')
        ->get()
        ->getRowArray();

    if (!$admin) {
        return $this->response
            ->setStatusCode(403)
            ->setJSON([
                'status' => false,
                'message' => 'Valid Admin account not found.'
            ]);
    }

    $assignmentModel = new \App\Models\AssignmentModel();

    $existing = $assignmentModel
        ->where('application_id', $applicationId)
        ->first();

    $assignmentData = [
        'application_id' => $applicationId,
        'evaluator_id' => $adminId,
        'assigned_evaluator_name' => $evaluatorName,
        'assigned_by' => $adminId,
        'status' => 'Assigned',
        'assigned_at' => date('Y-m-d H:i:s')
    ];

    if ($existing) {
        $saved = $assignmentModel->update(
            $existing['id'],
            $assignmentData
        );
    } else {
        $saved = $assignmentModel->insert($assignmentData);
    }

    if (!$saved) {
        return $this->response
            ->setStatusCode(500)
            ->setJSON([
                'status' => false,
                'message' => 'Failed to assign team member.',
                'errors' => $assignmentModel->errors()
            ]);
    }

    return $this->response->setJSON([
        'status' => true,
        'message' => $evaluatorName . ' assigned successfully.',
        'assignment' => [
            'application_id' => $applicationId,
            'evaluator_name' => $evaluatorName,
            'status' => 'Assigned'
        ]
    ]);
}


    // Get applications assigned to logged-in Evaluator
    public function assignedApplications()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        if ($session->get('role') !== 'Evaluator') {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => false,
                    'message' => 'Evaluator access required.'
                ]);
        }

        $db = \Config\Database::connect();

        $applications = $db->table('application_assignments aa')
            ->select('
                aa.id AS assignment_id,
                aa.application_id,
                aa.status AS assignment_status,
                aa.assigned_at,
                a.application_number,
                a.assessment_type,
                a.status AS application_status,
                a.payment_status,
                c.name AS company_name
            ')
            ->join(
                'assessment_applications a',
                'a.id = aa.application_id'
            )
            ->join(
                'companies c',
                'c.id = a.company_id',
                'left'
            )
            ->where('aa.evaluator_id', $session->get('user_id'))
            ->orderBy('aa.assigned_at', 'DESC')
            ->get()
            ->getResultArray();
            $totalApplications = count($applications);

        return $this->response->setJSON([
            'status' => true,
            'total' => count($applications),
            'applications' => $applications
        ]);
    }
        // Get Startup Dashboard Status
    public function startupStatus()
    {
        $session = session();

        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Please login first.'
                ]);
        }

        if ($session->get('role') !== 'Company') {
            return $this->response
                ->setStatusCode(403)
                ->setJSON([
                    'status' => false,
                    'message' => 'Company access required.'
                ]);
        }

        $userId = (int) $session->get('user_id');

        $db = \Config\Database::connect();

        $applications = $db->table('assessment_applications a')
    ->select('
        a.id,
        a.company_id,
        a.application_number,
        a.assessment_type,
        a.status,
        a.payment_status,
        a.created_at,
        c.name AS company_name,
        aa.assigned_evaluator_name AS assigned_evaluator,
        aa.status AS assignment_status,
        e.total_score AS overall_score,
        e.status AS evaluation_status
    ')
    ->join('companies c', 'c.id = a.company_id', 'left')
    ->join(
        'application_assignments aa',
        'aa.application_id = a.id',
        'left'
    )
    ->join('evaluations e', 'e.application_id = a.id', 'left')
    ->orderBy('a.created_at', 'DESC')
    ->get()
    ->getResultArray();

        foreach ($applications as &$application) {

            $application['approved'] =
                ($application['evaluation_status'] === 'Approved');

            $application['certificate_download_url'] =
                !empty($application['verification_id'])
                ? base_url(
                    'api/certificate/download/' .
                    $application['verification_id']
                )
                : null;

            $application['verification_url'] =
                !empty($application['verification_id'])
                ? base_url(
                    'verify?id=' .
                    $application['verification_id']
                )
                : null;
        }

        unset($application);

        return $this->response->setJSON([
            'status' => true,
            'total_applications' => count($applications),
            'latest_application' => $applications[0] ?? null,
            'applications' => $applications
        ]);
    }
        // Public Verified Companies Directory
    public function verifiedDirectory()
    {
        $db = \Config\Database::connect();

        $builder = $db->table('evaluations e')
            ->select('
                c.name AS company_name,
                c.industry,
                a.application_number,
                a.assessment_type,
                e.total_score AS final_score,
                e.verification_id,
                e.certificate_issued_at
            ')
            ->join(
                'assessment_applications a',
                'a.id = e.application_id'
            )
            ->join(
                'companies c',
                'c.id = a.company_id'
            )
            ->where('e.status', 'Approved')
            ->where('e.verification_id IS NOT NULL')
            ->where('e.verification_id !=', '');

        // Search by company name or application number
        $search = trim((string) $this->request->getGet('search'));

        if ($search !== '') {
            $builder->groupStart()
                ->like('c.name', $search)
                ->orLike('a.application_number', $search)
                ->groupEnd();
        }

        // Filter by industry
        $industry = trim((string) $this->request->getGet('industry'));

        if ($industry !== '') {
            $builder->where('c.industry', $industry);
        }

        $companies = $builder
            ->orderBy('e.certificate_issued_at', 'DESC')
            ->get()
            ->getResultArray();

        foreach ($companies as &$company) {
            $company['verification_url'] = base_url(
                'verify?id=' . $company['verification_id']
            );

            $company['certificate_download_url'] = base_url(
                'api/certificate/download/' . $company['verification_id']
            );
        }

        unset($company);

        return $this->response->setJSON([
            'status' => true,
            'total' => count($companies),
            'companies' => $companies
        ]);
    }
    // GET: Fetch Wizard Progress
public function getWizardProgress()
{
    $session = session();

    if (!$session->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'message' => 'User is not logged in'
            ]);
    }

    $userId = $session->get('user_id');

    $companyModel = new CompanyModel();

    $company = $companyModel
        ->where('user_id', $userId)
        ->first();

    if (!$company) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'status' => false,
                'message' => 'Company profile not found',
                'current_step' => 1
            ]);
    }

    return $this->response->setJSON([
        'status' => true,
        'current_step' => (int) $company['current_step']
    ]);
}


// PUT: Save Wizard Progress
public function saveWizardProgress()
{
    $session = session();

    if (!$session->get('logged_in')) {
        return $this->response
            ->setStatusCode(401)
            ->setJSON([
                'status' => false,
                'message' => 'User is not logged in'
            ]);
    }

    $userId = $session->get('user_id');

    $data = $this->request->getJSON(true);

    $step = (int) ($data['current_step'] ?? 0);

    if ($step < 1 || $step > 8) {
        return $this->response
            ->setStatusCode(422)
            ->setJSON([
                'status' => false,
                'message' => 'Current step must be between 1 and 8'
            ]);
    }

    $companyModel = new CompanyModel();

    $company = $companyModel
        ->where('user_id', $userId)
        ->first();

    if (!$company) {
        return $this->response
            ->setStatusCode(404)
            ->setJSON([
                'status' => false,
                'message' => 'Company profile not found'
            ]);
    }

    $companyModel->update($company['id'], [
        'current_step' => $step
    ]);

    return $this->response->setJSON([
        'status' => true,
        'message' => 'Wizard progress saved successfully',
        'current_step' => $step
    ]);
}
}