<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use App\Enums\UserRole;
use App\Models\User;

class UserRepository extends Repository
{
    /** @return User[] */
    public function findAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT id, name, email, role FROM users ORDER BY id'
        );

        $rows = $statement->fetchAll();
        $users = [];

        foreach ($rows as $row) {
            $users[] = new User(
                (int) $row['id'],
                $row['name'],
                $row['email'],
                UserRole::from((int) $row['role'])
            );
        }

        return $users;
    }

    /** @return User by email */
    public function findByEmail(string $email): ?User
    {
        $statement = $this->pdo->prepare(
            'SELECT id, name, email, role FROM users WHERE email = :email'
        );

        $statement->execute(['email' => $email]);

        $row = $statement->fetch();

        if($row === false) return null;

        return new User(
            (int) $row['id'],
            $row['name'],
            $row['email'],
            UserRole::from((int) $row['role'])
        );
    }
}