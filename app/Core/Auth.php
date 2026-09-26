<?php

declare(strict_types=1);

namespace App\Core;

use App\Models\User;
use App\Repositories\UserRepository;

class Auth
{
    private static ?User $user = null;
    private static bool $loaded = false;

    public static function user(): ?User
    {
        if (self::$loaded) {
            return self::$user;
        }

        self::$loaded = true;
        $id = $_SESSION['user_id'] ?? null;

        if (!is_int($id) || $id <= 0) {
            return null;
        }

        self::$user = (new UserRepository())->findById($id);

        if (self::$user === null) {
            unset($_SESSION['user_id']);
        }

        return self::$user;
    }

    public static function login(int $userId): void
    {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $userId;

        self::$user = null;
        self::$loaded = false;
    }
}