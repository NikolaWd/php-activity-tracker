<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Enums\EventAction;
use App\Repositories\EventRepository;
use App\Repositories\UserRepository;
use DateTimeImmutable;

class StatisticsController
{
    public function index(): string
    {
        $dateFrom = $_GET['date_from'] ?? '';
        $dateTo = $_GET['date_to'] ?? '';
        $user = $_GET['user_id'] ?? '';
        $action = $_GET['action'] ?? '';

        if (!is_string($dateFrom) || !is_string($dateTo) || !is_string($user) || !is_string($action)) {
            http_response_code(400);
            return 'Invalid filters.';
        }

        foreach ([$dateFrom, $dateTo] as $date) {
            if ($date === '') {
                continue;
            }

            $parsedDate = DateTimeImmutable::createFromFormat('!Y-m-d', $date);
            if ($parsedDate === false || $parsedDate->format('Y-m-d') !== $date) {
                http_response_code(400);
                return 'Invalid date.';
            }
        }

        if ($dateFrom !== '' && $dateTo !== '' && $dateFrom > $dateTo) {
            http_response_code(400);
            return 'Invalid date range.';
        }

        $userId = $user === '' ? null : filter_var($user, FILTER_VALIDATE_INT, [
            'options' => ['min_range' => 1],
        ]);

        if ($userId === false) {
            http_response_code(400);
            return 'Invalid user.';
        }

        $selectedAction = $action === '' ? null : EventAction::tryFrom($action);

        if ($action !== '' && $selectedAction === null) {
            http_response_code(400);
            return 'Invalid action.';
        }

        return view('statistics/index', [
            'pageTitle' => 'Activity statistics',
            'events' => (new EventRepository())->findActivity(
                $dateFrom !== '' ? $dateFrom : null,
                $dateTo !== '' ? $dateTo : null,
                $userId,
                $selectedAction
            ),
            'users' => (new UserRepository())->findAll(),
            'actions' => EventAction::cases(),
            'dateFrom' => $dateFrom,
            'dateTo' => $dateTo,
            'userId' => $user,
            'action' => $action,
        ]);
    }
}
