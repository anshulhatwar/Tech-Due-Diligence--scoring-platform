<?php

namespace App\Controllers;

class PublicPage extends BaseController
{
    public function home()
    {
        return view('public/home');
    }
}