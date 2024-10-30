<?php

namespace App\Http\Controller;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Core\Auth;

class AuthController
{
    public function login()
    {
        return view('Auth/login.php');
    }

    public function authenticate(LoginRequest $request)
    {
        Auth::attempt($request->email, $request->password);
        dd($request);
    }

    public function register()
    {

        return view('Auth/register.php');
    }

    public function create(RegisterRequest $request)
    {
        $user = User::create(['email' => $request->email, 'name' => $request->name, 'password' => $request->password]);
        Auth::attempt($user);
        dd("hi");
    }
}
