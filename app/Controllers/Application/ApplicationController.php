<?php

namespace App\Controllers\Application;

use App\Controllers\BaseController;
use App\Models\ApplicationModel;
use App\Models\CompanyModel;

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

        // Find the logged-in user's company
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

        // Generate a unique application number
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
                    'errors' => $applicationModel->errors()
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

    // List applications belonging to the logged-in user
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
            'applications' => $applications
        ]);
    }

    // Show one application belonging to the logged-in user
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
}