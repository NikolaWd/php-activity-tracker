<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Core\Repository;
use App\Enums\EventAction;
use DateTimeImmutable;
use PDO;

class EventRepository extends Repository
{
    public function findActivity(?string $dateFrom, ?string $dateTo, ?int $userId, ?EventAction $action): array
    {
        $conditions = [];
        $parameters = [];

        if ($dateFrom !== null) {
            $conditions[] = 'e.created_at >= :start_date';
            $parameters['start_date'] = $dateFrom . ' 00:00:00';
        }

        if ($dateTo !== null) {
            $conditions[] = 'e.created_at < :end_date';
            $parameters['end_date'] = (new DateTimeImmutable($dateTo))->modify('+1 day')->format('Y-m-d 00:00:00');
        }

        if ($userId !== null) {
            $conditions[] = 'e.user_id = :user_id';
            $parameters['user_id'] = $userId;
        }

        if ($action !== null) {
            $conditions[] = 'e.action = :action';
            $parameters['action'] = $action->value;
        }

        $sql = 'SELECT e.created_at, e.action, e.target, u.name, u.email
                FROM events e JOIN users u ON u.id = e.user_id';

        if ($conditions !== []) {
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        $sql .= ' ORDER BY e.created_at DESC, e.id DESC';

        $statement = $this->pdo->prepare($sql);

        foreach ($parameters as $key => $value) {
            $statement->bindValue(':' . $key, $value, $key === 'user_id' ? PDO::PARAM_INT : PDO::PARAM_STR);
        }

        $statement->execute();
        return $statement->fetchAll();
    }

    public function dailyReport(): array
    {
        $statement = $this->pdo->query(
            "SELECT DATE(created_at) AS date,
                SUM(CASE WHEN action = 'view-page' AND target = 'page-a' THEN 1 ELSE 0 END) AS page_a,
                SUM(CASE WHEN action = 'view-page' AND target = 'page-b' THEN 1 ELSE 0 END) AS page_b,
                SUM(CASE WHEN action = 'button-click' AND target = 'buy-a-cow' THEN 1 ELSE 0 END) AS buy_cow,
                SUM(CASE WHEN action = 'button-click' AND target = 'download' THEN 1 ELSE 0 END) AS download
             FROM events
             WHERE (action = 'view-page' AND target IN ('page-a', 'page-b'))
                OR (action = 'button-click' AND target IN ('buy-a-cow', 'download'))
             GROUP BY DATE(created_at)
             ORDER BY date ASC"
        );

        return $statement->fetchAll();
    }
}
