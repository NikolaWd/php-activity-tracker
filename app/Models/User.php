<?php

declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use App\Enums\UserRole;

class User extends Model
{
    public function __construct(
        int $id,
        private string $name,
        private string $email,
        private UserRole $role
    ) {
        parent::__construct($id);
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRole(): UserRole
    {
        return $this->role;
    }
}