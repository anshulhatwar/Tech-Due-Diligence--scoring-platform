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
        return view('dashboard/startup');
    }

    public function profile()
    {
        return view('dashboard/profile');
    }
    public function documents()
    {
        return view('dashboard/documents');
    }
    public function apply()
    {
        return view('dashboard/apply');
    }
    public function adminDashboard()
{
    return view('admin/dashboard');
}
public function adminParams()
{
    return view('admin/params');
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
    $this->setStepComplete('profile');
    return $this->response->setJSON(['status' => true, 'message' => 'Profile saved']);
}
}