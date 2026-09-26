<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;

$router->get('/', [HomeController::class, 'index'])->name('home');
$router->get('/about', [HomeController::class, 'about'])->name('about');
$router->get('/users', [UserController::class, 'index'])->name('users');