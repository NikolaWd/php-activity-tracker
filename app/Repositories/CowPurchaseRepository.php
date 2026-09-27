<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;

class CowPurchaseRepository extends Repository
{
    public function hasPurchased(int $userId): bool
    {
        $statement = $this->pdo->prepare('SELECT 1 FROM cow_purchases WHERE user_id = :user_id');
        $statement->execute(['user_id' => $userId]);

        return $statement->fetchColumn() !== false;
    }
}
