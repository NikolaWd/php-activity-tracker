<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;

$router->get('/', [HomeController::class, 'index'])->name('home');
$router->get('/users', [UserController::class, 'index'])->name('users');
$router->get('/login', [AuthController::class, 'login'])->name('login');
$router->post('/login', [AuthController::class, 'login_post'])->name('login.post');
$router->get('/register', [AuthController::class, 'register'])->name('register');
$router->post('/register', [AuthController::class, 'register_post'])->name('register.post');