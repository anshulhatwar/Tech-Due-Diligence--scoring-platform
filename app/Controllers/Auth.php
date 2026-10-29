<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function dashboard()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    return view('dashboard/startup', $this->userData());
}

    public function profile()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    return view('dashboard/profile', $this->userData());
}
   public function documents()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    if ($redirect = $this->guardStep('documents')) return $redirect;
    return view('dashboard/documents', $this->userData());
}
    public function apply()
{
    if (!session()->get('logged_in')) {
        return redirect()->to(base_url('login'));
    }
    if ($redirect = $this->guardStep('apply')) return $redirect;
    return view('dashboard/apply', $this->userData());
}
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
private function getStepStatus(): array
{
    $session = session();
    return $session->get('wizard_steps') ?? [
        'profile'     => 'active',
        'documents'   => 'locked',
        'apply'       => 'locked',
    ];
}

private function setStepComplete(string $step): void
{
    $steps = $this->getStepStatus();
    $steps[$step] = 'completed';

    // Next step unlock karo
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
    if ($steps[$step] === 'locked') {
        // Pehle wale step pe bhejo
        $order = ['profile', 'documents', 'apply'];
        $idx = array_search($step, $order);
        $prev = $order[$idx - 1] ?? 'profile';
        return redirect()->to(base_url($prev))->with('error', 'Pehle is step ko complete karo.');
    }
    return null;
}
public function documentsSave()
{
    $this->setStepComplete('documents');
    return $this->response->setJSON(['status' => true, 'message' => 'Documents saved']);
}

public function profileSave()
{
    $session = session();

    // Check login
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

    // Check whether profile already exists
    $company = $companyModel
        ->where('user_id', $userId)
        ->first();

    // If profile exists, update it
    if ($company) {
        $data = [
            'name'                  => $this->request->getPost('companyName'),
            'founder_details'       => $this->request->getPost('founderDetails'),
            'contact_email'         => $this->request->getPost('contactEmail'),
            'contact_phone'         => $this->request->getPost('contactPhone'),
            'website'               => $this->request->getPost('website'),
            'location'              => $this->request->getPost('location'),
            'industry'              => $this->request->getPost('industry'),
            'year_established'      => $this->request->getPost('yearEstablished'),
            'team_size'             => $this->request->getPost('teamSize'),
            'company_description'   => $this->request->getPost('companyDescription'),
            'problem_statement'     => $this->request->getPost('problemStatement'),
            'product_service'       => $this->request->getPost('productService'),
            'business_model'        => $this->request->getPost('businessModel'),
            'usp'                   => $this->request->getPost('usp'),
            'technology_used'       => $this->request->getPost('technologyUsed'),
            'intellectual_property' => $this->request->getPost('intellectualProperty'),
        ];

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
        // Create new profile
        $data = [
            'user_id'               => $userId,
            'name'                  => $this->request->getPost('companyName'),
            'founder_details'       => $this->request->getPost('founderDetails'),
            'contact_email'         => $this->request->getPost('contactEmail'),
            'contact_phone'         => $this->request->getPost('contactPhone'),
            'website'               => $this->request->getPost('website'),
            'location'              => $this->request->getPost('location'),
            'industry'              => $this->request->getPost('industry'),
            'year_established'      => $this->request->getPost('yearEstablished'),
            'team_size'             => $this->request->getPost('teamSize'),
            'company_description'   => $this->request->getPost('companyDescription'),
            'problem_statement'     => $this->request->getPost('problemStatement'),
            'product_service'        => $this->request->getPost('productService'),
            'business_model'        => $this->request->getPost('businessModel'),
            'usp'                   => $this->request->getPost('usp'),
            'technology_used'       => $this->request->getPost('technologyUsed'),
            'intellectual_property' => $this->request->getPost('intellectualProperty'),
        ];

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

    // Mark profile step complete
    $this->setStepComplete('profile');

    return $this->response->setJSON([
        'status' => true,
        'message' => 'Company profile saved successfully.'
    ]);
}
private function userData(): array
{
    $name = session()->get('name') ?? 'User';
   $parts = preg_split('/\s+/', trim($name));
    $initials = strtoupper(substr($parts[0], 0, 1) . (isset($parts[1]) ? substr($parts[1], 0, 1) : ''));
    return [
        'userName' => $name,
        'userInitials' => $initials ?: 'U',
    ];
}
}