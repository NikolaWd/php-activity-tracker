<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Middleware;

class GuestMiddleware implements Middleware
{
    public function handle(): bool
    {
        if (Auth::user() === null) {
            return true;
        }

        header('Location: ' . route('home'), true, 303);
        return false;
    }
}
