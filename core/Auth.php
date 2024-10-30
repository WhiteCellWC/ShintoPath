<?php

namespace Core;

use App\Models\User;

class Auth
{
    public static function attempt(string | User $user, $password = null)
    {
        $correctLoginCredentials = false;
        if (gettype($user) === "string") {
            $user = User::where('email', $user)->first();
            $user_confidential = App::resolve(Database::class)->query("SELECT password FROM users WHERE email = :email", ['email' => $user->email])->fetch();
            $correctLoginCredentials = password_verify($password, $user_confidential['password']);
        } else {
            $correctLoginCredentials = true;
        }

        if($correctLoginCredentials) {
            // Session::setKey();
        }
    }

    public static function user() {}
}
