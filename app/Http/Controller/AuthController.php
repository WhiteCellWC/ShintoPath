<?php

namespace App\Http\Controller;

use App\Http\Requests\Auth\LoginRequest;
use Core\Request;

class AuthController
{
    public function loginView()
    {
        return view('Auth/login.php');
    }

    public function login(LoginRequest $request)
    {
        dd($request->email);
    }

    public function registerView()
    {
        view('Auth/register.php');
    }
}
