<?php

declare(strict_types=1);

namespace App\Actions\Cow;

use App\Actions\Event\RecordEvent;
use App\Core\Database;
use App\Enums\EventAction;
use App\Enums\EventTarget;
use PDOException;
use Throwable;

class BuyCow
{
    public function execute(int $userId): bool
    {
        $pdo = Database::connection();
        $pdo->beginTransaction();

        try {
            $statement = $pdo->prepare('INSERT INTO cow_purchases (user_id) VALUES (:user_id)');
            $statement->execute(['user_id' => $userId]);

            (new RecordEvent())->execute($userId, EventAction::ButtonClick, EventTarget::BuyCow);

            $pdo->commit();
            return true;
        } catch (Throwable $exception) {
            $pdo->rollBack();

            if ($exception instanceof PDOException && ($exception->errorInfo[1] ?? null) === 1062) {
                return false;
            }

            throw $exception;
        }
    }
}
