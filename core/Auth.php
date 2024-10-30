<?php

namespace Core;

use App\Models\User;

class Auth
{
    public static function attempt(string | User $email, $password)
    {
        $db = App::resolve(Database::class);
        if (gettype($email) === "string") {
            $user = $db->query("SELECT * FROM users WHERE email = :email", ['email' => $email])->fetch();
        }
        dd($user);
    }

    public static function user() {}
}
