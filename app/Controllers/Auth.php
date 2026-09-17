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
}