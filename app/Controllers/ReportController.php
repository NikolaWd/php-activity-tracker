<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\EventRepository;
use DateTimeImmutable;

class ReportController
{
    public function index(): string
    {
        $result = (new EventRepository())->dailyReport();
        $byDate = [];

        foreach ($result as $row) {
            $byDate[$row['date']] = [
                'date' => $row['date'],
                'page_a' => (int) $row['page_a'],
                'page_b' => (int) $row['page_b'],
                'buy_cow' => (int) $row['buy_cow'],
                'download' => (int) $row['download'],
            ];
        }

        $rows = [];

        if ($byDate !== []) {
            $day = new DateTimeImmutable(array_key_first($byDate));
            $lastDay = new DateTimeImmutable(array_key_last($byDate));

            while ($day <= $lastDay) {
                $date = $day->format('Y-m-d');
                $rows[] = $byDate[$date] ?? [
                    'date' => $date,
                    'page_a' => 0,
                    'page_b' => 0,
                    'buy_cow' => 0,
                    'download' => 0,
                ];
                $day = $day->modify('+1 day');
            }
        }

        return view('reports/index', ['pageTitle' => 'Reports', 'rows' => $rows]);
    }
}
