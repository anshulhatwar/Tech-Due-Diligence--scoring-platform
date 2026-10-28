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
    return view('admin/dashboard');
}
public function adminParams()
{
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
    $this->setStepComplete('profile');
    return $this->response->setJSON(['status' => true, 'message' => 'Profile saved']);
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