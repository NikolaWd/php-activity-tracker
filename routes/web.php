<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Enums\UserRole;
use App\Middleware\AuthMiddleware;
use App\Middleware\GuestMiddleware;
use App\Middleware\RoleMiddleware;

$router->get('/', [HomeController::class, 'index'])->name('home');

$router->get('/users', [UserController::class, 'index'])
    ->middleware(
        [
            new AuthMiddleware(),
            new RoleMiddleware(UserRole::Admin)
        ]
    )->name('users');

$router->get('/login', [AuthController::class, 'login'])
    ->middleware([new GuestMiddleware()])->name('login');

$router->post('/login', [AuthController::class, 'login_post'])
    ->middleware([new GuestMiddleware()])->name('login.post');

$router->get('/register', [AuthController::class, 'register'])
    ->middleware([new GuestMiddleware()])->name('register');

$router->post('/register', [AuthController::class, 'register_post'])
    ->middleware([new GuestMiddleware()])->name('register.post');

$router->post('/logout', [AuthController::class, 'logout'])
    ->middleware([new AuthMiddleware()])->name('logout');
