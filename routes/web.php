<?php

use App\Http\Controller\AuthController;
use Core\Router;

Router::group(['middleware' => 'guest'], function () {

    Router::get('/login', [AuthController::class, 'login'])->name('login.view');

    Router::post('/login', [AuthController::class, 'authenticate'])->name('login.authenticate');

    Router::get('/register', [AuthController::class, 'register'])->name('register.view');

    Router::post('/register', [AuthController::class, 'create'])->name('register.create');
});

Router::get('/', [AuthController::class, 'register'])->name('home');
