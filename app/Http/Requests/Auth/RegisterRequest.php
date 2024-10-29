<?php

namespace App\Http\Requests\Auth;

use Core\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:8|max:16',
        ];
    }
}
