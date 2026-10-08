<?php

namespace App\Controllers\Company;

use App\Controllers\BaseController;
use App\Models\CompanyModel;

class CompanyController extends BaseController
{
    /**
     * Create Company Profile
     */
    public function create()
    {
        $session = session();

        // Check login
        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'User is not logged in'
                ]);
        }

        $userId = $session->get('user_id');

        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
            'founder_details' => 'required',
            'contact_email' => 'required|valid_email|max_length[100]',
            'contact_phone' => 'required|min_length[10]|max_length[20]',
            'website' => 'permit_empty|max_length[255]',
            'industry' => 'permit_empty|max_length[100]',
            'stage' => 'permit_empty|max_length[50]',
            'location' => 'permit_empty|max_length[150]',
            'year_established' => 'permit_empty|integer',
            'team_size' => 'permit_empty|integer',
            'company_description' => 'required',
            'problem_statement' => 'required',
            'product_service' => 'required',
            'business_model' => 'required|max_length[100]',
            'usp' => 'required',
            'technology_used' => 'required',
            'intellectual_property' => 'permit_empty'
        ];

        // Validate request
        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
        }

        $companyModel = new CompanyModel();

        // Check existing company profile
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

        // Company profile data
        $data = [
            'user_id' => $userId,

            'name' => $this->request->getPost('name'),
            'founder_details' => $this->request->getPost('founder_details'),
            'contact_email' => $this->request->getPost('contact_email'),
            'contact_phone' => $this->request->getPost('contact_phone'),

            'website' => $this->request->getPost('website'),
            'industry' => $this->request->getPost('industry'),
            'stage' => $this->request->getPost('stage'),
            'location' => $this->request->getPost('location'),

            'year_established' => $this->request->getPost('year_established'),
            'team_size' => $this->request->getPost('team_size'),

            'company_description' => $this->request->getPost('company_description'),
            'problem_statement' => $this->request->getPost('problem_statement'),
            'product_service' => $this->request->getPost('product_service'),
            'business_model' => $this->request->getPost('business_model'),
            'usp' => $this->request->getPost('usp'),
            'technology_used' => $this->request->getPost('technology_used'),
            'intellectual_property' => $this->request->getPost('intellectual_property')
        ];

        // Insert company profile
        if (!$companyModel->insert($data)) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => false,
                    'message' => 'Failed to create company profile',
                    'errors' => $companyModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Company profile created successfully',
            'company_id' => $companyModel->getInsertID()
        ]);
    }


    /**
     * Get Company Profile
     */
    public function show()
    {
        $session = session();

        // Check login
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

        // Get company profile of logged-in user
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


    /**
     * Update Existing Company Profile
     */
    public function update()
    {
        $session = session();

        // Check login
        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'User is not logged in'
                ]);
        }

        $userId = $session->get('user_id');

        /*
         * PUT request data
         */
        $data = $this->request->getRawInput();

        // Validation rules
        $rules = [
            'name' => 'required|min_length[2]|max_length[150]',
            'founder_details' => 'required',
            'contact_email' => 'required|valid_email|max_length[100]',
            'contact_phone' => 'required|min_length[10]|max_length[20]',
            'website' => 'permit_empty|max_length[255]',
            'industry' => 'permit_empty|max_length[100]',
            'stage' => 'permit_empty|max_length[50]',
            'location' => 'permit_empty|max_length[150]',
            'year_established' => 'permit_empty|integer',
            'team_size' => 'permit_empty|integer',
            'company_description' => 'required',
            'problem_statement' => 'required',
            'product_service' => 'required',
            'business_model' => 'required|max_length[100]',
            'usp' => 'required',
            'technology_used' => 'required',
            'intellectual_property' => 'permit_empty'
        ];

        // Validate PUT data
        if (!$this->validateData($data, $rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
        }

        $companyModel = new CompanyModel();

        // Find existing company for logged-in user
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

        // Data to update
        $updateData = [
            'name' => $data['name'],
            'founder_details' => $data['founder_details'],
            'contact_email' => $data['contact_email'],
            'contact_phone' => $data['contact_phone'],

            'website' => $data['website'] ?? null,
            'industry' => $data['industry'] ?? null,
            'stage' => $data['stage'] ?? null,
            'location' => $data['location'] ?? null,

            'year_established' => $data['year_established'] ?? null,
            'team_size' => $data['team_size'] ?? null,

            'company_description' => $data['company_description'],
            'problem_statement' => $data['problem_statement'],
            'product_service' => $data['product_service'],
            'business_model' => $data['business_model'],
            'usp' => $data['usp'],
            'technology_used' => $data['technology_used'],
            'intellectual_property' => $data['intellectual_property'] ?? null
        ];

        // Update company profile
        if (!$companyModel->update($company['id'], $updateData)) {
            return $this->response
                ->setStatusCode(500)
                ->setJSON([
                    'status' => false,
                    'message' => 'Failed to update company profile',
                    'errors' => $companyModel->errors()
                ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Company profile updated successfully',
            'company_id' => $company['id']
        ]);
    }
}