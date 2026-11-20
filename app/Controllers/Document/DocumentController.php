<?php

namespace App\Controllers\Document;

use App\Controllers\BaseController;
use App\Models\DocumentModel;
use App\Models\CompanyModel;

class DocumentController extends BaseController
{
    protected $documentModel;
    protected $companyModel;

    public function __construct()
    {
        $this->documentModel = new DocumentModel();
        $this->companyModel = new CompanyModel();
    }

    // Get logged-in user ID
    private function getUserId()
    {
        return session()->get('user_id');
    }

    // Check whether user is logged in
    private function checkLogin()
    {
        if (!$this->getUserId()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Please login first.'
            ])->setStatusCode(401);
        }

        return null;
    }

    // GET: List documents belonging to logged-in user
    public function index()
    {
        $loginError = $this->checkLogin();

        if ($loginError !== null) {
            return $loginError;
        }

        $documents = $this->documentModel
            ->where('user_id', $this->getUserId())
            ->findAll();

        return $this->response->setJSON([
            'status' => true,
            'count'  => count($documents),
            'data'   => $documents
        ]);
    }

    // GET: Get one document
    public function show($id = null)
    {
        $loginError = $this->checkLogin();

        if ($loginError !== null) {
            return $loginError;
        }

        if (!is_numeric($id) || (int) $id <= 0) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Valid document ID is required.'
            ])->setStatusCode(400);
        }

        $document = $this->documentModel
            ->where('id', (int) $id)
            ->where('user_id', $this->getUserId())
            ->first();

        if (!$document) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Document not found.'
            ])->setStatusCode(404);
        }

        return $this->response->setJSON([
            'status' => true,
            'data'   => $document
        ]);
    }

    // POST: Upload a document
    public function upload()
    {
        $loginError = $this->checkLogin();

        if ($loginError !== null) {
            return $loginError;
        }

        $userId = $this->getUserId();

        $documentName = trim((string) $this->request->getPost('document_name'));
        $documentType = trim((string) $this->request->getPost('document_type'));

        if ($documentName === '' || $documentType === '') {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Document name and document type are required.'
            ])->setStatusCode(400);
        }

        // Check company profile
        $company = $this->companyModel
            ->where('user_id', $userId)
            ->first();

        if (!$company) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Please create your company profile before uploading documents.'
            ])->setStatusCode(400);
        }

        // Validate uploaded file
        $file = $this->request->getFile('document');

        if (!$file || !$file->isValid()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Please select a valid document file.'
            ])->setStatusCode(400);
        }

        $allowedExtensions = ['pdf', 'jpg', 'jpeg', 'png'];
        $extension = strtolower($file->getExtension());

        if (!in_array($extension, $allowedExtensions, true)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Only PDF, JPG, JPEG and PNG files are allowed.'
            ])->setStatusCode(400);
        }

        if ($file->getSizeByUnit('mb') > 5) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'File size must not exceed 5 MB.'
            ])->setStatusCode(400);
        }

        // Create upload directory
        $uploadPath = WRITEPATH . 'uploads/documents/';

        if (!is_dir($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        // Generate a safe unique file name
        $newFileName = $file->getRandomName();

        if (!$file->move($uploadPath, $newFileName)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Failed to upload document.'
            ])->setStatusCode(500);
        }

        // Save document information
        $documentData = [
            'user_id'       => $userId,
            'company_id'    => $company['id'],
            'document_name' => $documentName,
            'document_type' => $documentType,
            'file_name'     => $newFileName,
            'file_path'     => $uploadPath . $newFileName,
            'status'        => 'Pending'
        ];

        $documentId = $this->documentModel->insert($documentData);

        if (!$documentId) {
            // Remove uploaded file if database insert fails
            if (is_file($uploadPath . $newFileName)) {
                unlink($uploadPath . $newFileName);
            }

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Document uploaded, but its database record could not be saved.'
            ])->setStatusCode(500);
        }

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Document uploaded successfully.',
            'document_id' => $documentId,
            'file_name'   => $newFileName,
            'status_name' => 'Pending'
        ])->setStatusCode(201);
    }

    // DELETE: Delete a document owned by the logged-in user
    public function deleteDocument($id = null)
    {
        $loginError = $this->checkLogin();

        if ($loginError !== null) {
            return $loginError;
        }

        if (!is_numeric($id) || (int) $id <= 0) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Valid document ID is required.'
            ])->setStatusCode(400);
        }

        $document = $this->documentModel
            ->where('id', (int) $id)
            ->where('user_id', $this->getUserId())
            ->first();

        if (!$document) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Document not found or access denied.'
            ])->setStatusCode(404);
        }

        // Delete database record
        if (!$this->documentModel->delete((int) $id)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Failed to delete document.'
            ])->setStatusCode(500);
        }

        // Delete physical file
        $filePath = $document['file_path'] ?? '';

        if ($filePath !== '' && is_file($filePath)) {
            unlink($filePath);
        }

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Document deleted successfully.',
            'document_id' => (int) $id
        ]);
    }

    // PUT: Update document status (Admin/Evaluator only)
    public function updateStatus($id = null)
    {
        // Check login
        $loginError = $this->checkLogin();

        if ($loginError !== null) {
            return $loginError;
        }

        // Check user role
        $role = strtolower(trim((string) session()->get('role')));

        if (!in_array($role, ['admin', 'evaluator'], true)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Access denied. Only Admin or Evaluator can update document status.'
            ])->setStatusCode(403);
        }

        // Validate document ID
        if (!is_numeric($id) || (int) $id <= 0) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Valid document ID is required.'
            ])->setStatusCode(400);
        }

        // Read PUT request data
        $data = $this->request->getRawInput();
        $status = trim((string) ($data['status'] ?? ''));

        // Only Approved or Rejected are accepted
        if (!in_array($status, ['Approved', 'Rejected'], true)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Status must be Approved or Rejected.'
            ])->setStatusCode(400);
        }

        // Check whether document exists
        $document = $this->documentModel->find((int) $id);

        if (!$document) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Document not found.'
            ])->setStatusCode(404);
        }

        // Update status
        $updated = $this->documentModel->update((int) $id, [
            'status' => $status
        ]);

        if (!$updated) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Failed to update document status.'
            ])->setStatusCode(500);
        }

        return $this->response->setJSON([
            'status'      => true,
            'message'     => 'Document status updated successfully.',
            'document_id' => (int) $id,
            'status_name' => $status
        ]);
    }
}
