<?php

declare(strict_types=1);

use App\Core\Database;
use App\Enums\UserRole;

if (PHP_SAPI !== 'cli') {
    exit('Seeders must run from the command line.');
}

require_once dirname(__DIR__, 2) . '/vendor/autoload.php';

$pdo = Database::connection();
$password = 'DemoPassword123!';
$createdAt = gmdate('Y-m-d H:i:s', time() - 21 * 86400);

$firstNames = ['Ana', 'Marko', 'Jelena', 'Petar', 'Milica', 'Nikola', 'Sara', 'Luka', 'Maja', 'Ivan'];
$lastNames = ['Jovic', 'Petrovic', 'Ilic', 'Nikolic', 'Markovic', 'Stojanovic', 'Kovac'];

$users = [];

for ($i = 1; $i <= 3; $i++) {
    $users[] = ["Admin {$i}", "admin{$i}@seed.test", UserRole::Admin];
}

for ($i = 1; $i <= 50; $i++) {
    $name = $firstNames[random_int(0, count($firstNames) - 1)] . ' '
        . $lastNames[random_int(0, count($lastNames) - 1)];

    $users[] = [$name, sprintf('user%02d@seed.test', $i), UserRole::User];
}

$findUser = $pdo->prepare('SELECT id FROM users WHERE email = :email');
$insertUser = $pdo->prepare(
    'INSERT INTO users (name, email, password, role, created_at)
     VALUES (:name, :email, :password, :role, :created_at)'
);

$inserted = 0;

foreach ($users as [$name, $email, $role]) {
    $findUser->execute(['email' => $email]);

    if ($findUser->fetchColumn() !== false) {
        continue;
    }

    $insertUser->execute([
        'name' => $name,
        'email' => $email,
        'password' => password_hash($password, PASSWORD_DEFAULT),
        'role' => $role->value,
        'created_at' => $createdAt,
    ]);

    $inserted++;
}

echo "Inserted {$inserted} users (skipped " . (count($users) - $inserted) . " existing).\n";
echo "Demo admin: admin1@seed.test / {$password}\n";
echo "Demo user: user01@seed.test / {$password}\n";
