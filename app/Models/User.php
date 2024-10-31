<?php

namespace App\Models;

use App\Models\Model;

class User extends Model
{
    protected array $fillable = [
        'name',
        'email',
        'password'
    ];

    protected array $hidden = [
        'password',
    ];

    protected array $cast = [
        'password' => 'hashed',
    ];
}
