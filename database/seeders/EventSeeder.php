<?php

declare(strict_types=1);

use App\Core\Database;

if (PHP_SAPI !== 'cli') {
    exit('Seeders must run from the command line.');
}

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$pdo = Database::connection();
$seededUsers = $pdo->query(
    "SELECT id, created_at FROM users
     WHERE email IN ('admin1@seed.test', 'admin2@seed.test', 'admin3@seed.test')
        OR email LIKE 'user__@seed.test'"
)->fetchAll();

if (count($seededUsers) !== 53) {
    throw new RuntimeException('Run UserSeeder.php first (53 demo users are required).');
}

$firstUser = $seededUsers[0];
$alreadySeeded = $pdo->prepare(
    "SELECT id FROM events
     WHERE user_id = :user_id AND action = 'registration'
       AND target IS NULL AND created_at = :created_at LIMIT 1"
);
$alreadySeeded->execute([
    'user_id' => $firstUser['id'],
    'created_at' => $firstUser['created_at'],
]);

if ($alreadySeeded->fetchColumn() !== false) {
    echo "Demo events already exist; nothing inserted.\n";
    return;
}

$userIds = array_map(static fn (array $user): int => (int) $user['id'], $seededUsers);
$purchased = $pdo->query('SELECT user_id FROM cow_purchases')->fetchAll(PDO::FETCH_COLUMN);
$purchasedIds = array_map('intval', $purchased);
$availableCowUserIds = array_values(array_diff($userIds, $purchasedIds));

$eventTypes = [
    ['login', null],
    ['logout', null],
    ['view-page', 'page-a'],
    ['view-page', 'page-b'],
    ['button-click', 'buy-a-cow'],
    ['button-click', 'download'],
];

$insertEvent = $pdo->prepare(
    'INSERT INTO events (user_id, action, target, created_at)
     VALUES (:user_id, :action, :target, :created_at)'
);
$insertPurchase = $pdo->prepare(
    'INSERT INTO cow_purchases (user_id, purchases_at)
     VALUES (:user_id, :purchases_at)'
);

$pdo->beginTransaction();

try {
    // Every demo user has one registration event at the time their account was created.
    foreach ($seededUsers as $user) {
        $insertEvent->execute([
            'user_id' => $user['id'],
            'action' => 'registration',
            'target' => null,
            'created_at' => $user['created_at'],
        ]);
    }

    // 53 registrations + 87 activity events = 140 events in total.
    for ($i = 0; $i < 87; $i++) {
        // Ensure each report series has at least one event.
        $typeIndex = $i < 4 ? $i + 2 : random_int(0, count($eventTypes) - 1);
        [$action, $target] = $eventTypes[$typeIndex];

        if ($target === 'buy-a-cow' && $availableCowUserIds !== []) {
            $index = random_int(0, count($availableCowUserIds) - 1);
            $userId = $availableCowUserIds[$index];
            array_splice($availableCowUserIds, $index, 1);
        } else {
            if ($target === 'buy-a-cow') {
                $target = 'download';
            }

            $userId = $userIds[random_int(0, count($userIds) - 1)];
        }

        $createdAt = null;

        foreach ($seededUsers as $user) {
            if ((int) $user['id'] === $userId) {
                $createdAt = (new DateTimeImmutable(
                    $user['created_at'],
                    new DateTimeZone('UTC')
                ))->getTimestamp();
                break;
            }
        }

        $eventTime = gmdate('Y-m-d H:i:s', random_int(
            max($createdAt, time() - 13 * 86400),
            time()
        ));

        if ($target === 'buy-a-cow') {
            $insertPurchase->execute([
                'user_id' => $userId,
                'purchases_at' => $eventTime,
            ]);
        }

        $insertEvent->execute([
            'user_id' => $userId,
            'action' => $action,
            'target' => $target,
            'created_at' => $eventTime,
        ]);
    }

    $pdo->commit();
} catch (Throwable $exception) {
    $pdo->rollBack();
    throw $exception;
}

echo "Inserted 140 demo events (53 registrations and 87 activity events).\n";
