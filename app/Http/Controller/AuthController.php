<?php

namespace App\Http\Controller;

use App\Http\Requests\Auth\LoginRequest;
use Core\Request;
use Core\Validator;

class AuthController
{
    public function login()
    {
        return view('Auth/login.php');
    }

    public function authenticate(LoginRequest $request)
    {
        dd($request);
    }

    public function register()
    {
        view('Auth/register.php');
    }

    public function create(Request $request)
    {
        dd($request);
    }
}
