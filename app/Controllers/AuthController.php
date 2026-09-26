<?php

declare(strict_types=1);

namespace App\Controllers;

class AuthController
{
    public function login(): string
    {
        return view('auth/login', ['pageTitle' => 'Login page']);
    }

    public function login_post()
    {
        echo "Login...";
    }

    public function register(): string
    {
        return view('auth/register', ['pageTitle' => 'Register page']);
    }

    public function register_post()
    {
        echo "Register...";
    }
}
