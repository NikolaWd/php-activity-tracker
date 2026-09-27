<?php

declare(strict_types=1);

use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Controllers\AuthController;
use App\Controllers\PageController;
use App\Controllers\StatisticsController;
use App\Controllers\ReportController;
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

$router->get('/page-a', [PageController::class, 'pageA'])
    ->middleware([new AuthMiddleware()])->name('page-a');
$router->post('/page-a/buy', [PageController::class, 'buyCow'])
    ->middleware([new AuthMiddleware()])->name('page-a.buy');
$router->get('/page-b', [PageController::class, 'pageB'])
    ->middleware([new AuthMiddleware()])->name('page-b');
$router->post('/page-b/download', [PageController::class, 'download'])
    ->middleware([new AuthMiddleware()])->name('page-b.download');

$router->get('/statistics', [StatisticsController::class, 'index'])
    ->middleware([new AuthMiddleware(), new RoleMiddleware(UserRole::Admin)])->name('statistics');
$router->get('/reports', [ReportController::class, 'index'])
    ->middleware([new AuthMiddleware()])->name('reports');
