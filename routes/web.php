<?php

use App\Http\Controller\AuthController;
use Core\Router;

Router::group(['middleware' => 'guest'], function () {
    Router::get('/login', [AuthController::class, 'loginView'])->name('login.view');

    Router::post('/login', [AuthController::class, 'login'])->name('login.authenticate');

    Router::get('/register', [AuthController::class, 'registerView'])->name('register.view');
});

Router::get('/', [AuthController::class, 'register'])->name('home');
