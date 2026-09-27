<?php

declare(strict_types=1);

namespace App\Actions\User;

use App\Actions\Event\RecordEvent;
use App\Core\Database;
use App\Enums\EventAction;
use App\Enums\UserRole;
use PDO;
use Throwable;

class RegisterUser
{
    private PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }

    public function execute(string $name, string $email, string $password): int
    {
        $name = trim($name);
        $email = trim($email);

        if ($name === '' || filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            throw new \InvalidArgumentException('Invalid name or email.');
        }

        if (strlen($password) < 8) {
            throw new \InvalidArgumentException('Password must have at least 8 characters.');
        }

        $this->pdo->beginTransaction();

        try {
            $statement = $this->pdo->prepare(
                'INSERT INTO users (name, email, password, role)
                 VALUES (:name, :email, :password, :role)'
            );

            $statement->execute([
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_DEFAULT),
                'role' => UserRole::User->value,
            ]);

            $userId = (int) $this->pdo->lastInsertId();
            (new RecordEvent())->execute($userId, EventAction::Registration);

            $this->pdo->commit();
            return $userId;
        } catch (Throwable $exception) {
            $this->pdo->rollBack();
            throw $exception;
        }
    }
}
