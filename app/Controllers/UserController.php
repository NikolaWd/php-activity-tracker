<?php

declare(strict_types=1);

namespace App\Controllers;

class UserController
{
    public function index()
    {
        $users = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
        ];

        return view('users/index', ['users' => $users, 'pageTitle' => 'User List']);
    }
}