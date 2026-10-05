<?php

namespace App\Controllers\Company;

use App\Controllers\BaseController;
use App\Models\CompanyModel;

class CompanyController extends BaseController
{
    // =========================
    // CREATE COMPANY PROFILE
    // =========================
    public function create()
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

        $rules = [
            'name' => 'required|min_length[2]',
            'industry' => 'permit_empty|max_length[100]',
            'stage' => 'permit_empty|max_length[50]',
            'location' => 'permit_empty|max_length[150]'
        ];

        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
        }

        $companyModel = new CompanyModel();

        $existingCompany = $companyModel
            ->where('user_id', $userId)
            ->first();

        if ($existingCompany) {
            return $this->response
                ->setStatusCode(409)
                ->setJSON([
                    'status' => false,
                    'message' => 'Company profile already exists'
                ]);
        }

        $data = [
            'user_id' => $userId,
            'name' => $this->request->getPost('name'),
            'industry' => $this->request->getPost('industry'),
            'stage' => $this->request->getPost('stage'),
            'location' => $this->request->getPost('location')
        ];

        $companyModel->insert($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Company profile created successfully',
            'company_id' => $companyModel->getInsertID()
        ]);
    }


    // =========================
    // GET COMPANY PROFILE
    // =========================
    public function show()
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
                    'message' => 'Company profile not found'
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'company' => $company
        ]);
    }


    // =========================
    // UPDATE COMPANY PROFILE
    // =========================
    public function update()
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
                    'message' => 'Company profile not found'
                ]);
        }

        // Get PUT request data
        $input = $this->request->getRawInput();

        $rules = [
            'name' => 'required|min_length[2]',
            'industry' => 'permit_empty|max_length[100]',
            'stage' => 'permit_empty|max_length[50]',
            'location' => 'permit_empty|max_length[150]'
        ];

        if (!$this->validateData($input, $rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
        }

        $data = [
            'name' => $input['name'],
            'industry' => $input['industry'] ?? null,
            'stage' => $input['stage'] ?? null,
            'location' => $input['location'] ?? null
        ];

        $companyModel->update($company['id'], $data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Company profile updated successfully'
        ]);
    }
}