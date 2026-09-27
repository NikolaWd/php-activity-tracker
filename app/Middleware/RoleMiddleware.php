<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Core\Auth;
use App\Core\Middleware;
use App\Enums\UserRole;

class RoleMiddleware implements Middleware
{
    public function __construct(private UserRole $role)
    {
    }

    public function handle(): bool
    {
        if (Auth::user()?->getRole() === $this->role) {
            return true;
        }

        http_response_code(403);
        echo '403 Forbidden';
        return false;
    }
}
