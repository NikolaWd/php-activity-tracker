<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;

class UserController
{
    public function index(): string
    {
        $perPage = 10;
        $requestedPage = filter_var(
            $_GET['page'] ?? 1,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 1]]
        );

        $repository = new UserRepository();
        $totalUsers = $repository->countUsers();
        $totalPages = max(1, (int) ceil($totalUsers / $perPage));
        $page = min($requestedPage === false ? 1 : $requestedPage, $totalPages);
        $users = $repository->findAllUsers($perPage, ($page - 1) * $perPage);

        return view('users/index', [
            'users' => $users,
            'pageTitle' => 'User List',
            'page' => $page,
            'totalPages' => $totalPages,
        ]);
    }
}
