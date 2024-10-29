<?php

namespace App\Http\Requests\Auth;

use Core\Request;

class LoginRequest extends Request
{
    public function rules(): array  
    {
        return [
            'email' => 'required|email',
            'password' => 'required',
        ];
    }
}
