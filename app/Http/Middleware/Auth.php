<?php

namespace App\Http\Middleware;

use Core\Request;
use Core\Session;

class Auth
{
    public function handle(Request $request)
    {
        $user = Session::getKey('user');
        if(!$user) {
            
        }
    }
}
