<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\UserRepository;

class UserController
{
    public function index()
    {
        $users = (new UserRepository())->findAll();

        return view('users/index', ['users' => $users, 'pageTitle' => 'User List']);
    }
}