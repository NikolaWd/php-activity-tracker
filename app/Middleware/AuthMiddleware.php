<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Middleware;

class AuthMiddleware implements Middleware
{
    public function handle(): bool
    {
        if (Auth::user() !== null) {
            return true;
        }

        header('Location: ' . route('login'), true, 303);
        return false;
    }
}
