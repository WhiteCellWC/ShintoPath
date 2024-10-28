<?php

namespace App\Http\Controller;

use App\Models\Client;
use App\Models\User;

class AuthController
{
    public function loginView()
    {
        return view('Auth/login.php');
    }

    public function registerView()
    {
        view('Auth/register.php');
    }
}
