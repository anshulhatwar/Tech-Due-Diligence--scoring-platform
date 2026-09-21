<?php

namespace App\Controllers\Auth;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AuthController extends BaseController
{
    // =========================
    // REGISTER API
    // =========================
    public function register()
    {
        $rules = [
            'Name' => 'required|min_length[2]',
            'Email' => 'required|valid_email|is_unique[users.Email]',
            'Password' => 'required|min_length[6]',
            'Phone' => 'required|min_length[10]|max_length[20]',
            'Address' => 'required'
        ];

        if (!$this->validate($rules)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'errors' => $this->validator->getErrors()
                ]);
        }

        $userModel = new UserModel();

        $data = [
            'Name' => $this->request->getPost('Name'),
            'Email' => $this->request->getPost('Email'),

            'Password' => password_hash(
                $this->request->getPost('Password'),
                PASSWORD_DEFAULT
            ),

            'Phone' => $this->request->getPost('Phone'),
            'Address' => $this->request->getPost('Address'),

            // Default role for new registration
            'Role' => 'Company',

            'created_at' => date('Y-m-d H:i:s')
        ];

        $userModel->insert($data);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Registration successful'
        ]);
    }


    // =========================
    // LOGIN API
    // =========================
    public function login()
    {
        $email = $this->request->getPost('Email');
        $password = $this->request->getPost('Password');

        // Check empty fields
        if (empty($email) || empty($password)) {
            return $this->response
                ->setStatusCode(422)
                ->setJSON([
                    'status' => false,
                    'message' => 'Email and Password are required'
                ]);
        }

        $userModel = new UserModel();

        // Find user by email
        $user = $userModel
            ->where('Email', $email)
            ->first();

        // User not found
        if (!$user) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ]);
        }

        // Check password
        if (!password_verify($password, $user['Password'])) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'Invalid email or password'
                ]);
        }

        // Create session
        session()->set([
            'user_id' => $user['ID'],
            'email' => $user['Email'],
            'name' => $user['Name'],
            'role' => $user['Role'],
            'logged_in' => true
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Login successful',

            'user' => [
                'id' => $user['ID'],
                'name' => $user['Name'],
                'email' => $user['Email'],
                'role' => $user['Role']
            ]
        ]);
    }


    // =========================
    // CURRENT USER / SESSION API
    // =========================
    public function me()
    {
        $session = session();

        // Check whether user is logged in
        if (!$session->get('logged_in')) {
            return $this->response
                ->setStatusCode(401)
                ->setJSON([
                    'status' => false,
                    'message' => 'User is not logged in'
                ]);
        }

        // Return logged-in user's information
        return $this->response->setJSON([
            'status' => true,
            'user' => [
                'id' => $session->get('user_id'),
                'name' => $session->get('name'),
                'email' => $session->get('email'),
                'role' => $session->get('role')
            ]
        ]);
    }


    // =========================
    // LOGOUT API
    // =========================
    public function logout()
    {
        $session = session();

        // Destroy current user session
        $session->destroy();

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Logout successful'
        ]);
    }
}