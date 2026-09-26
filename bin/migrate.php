<?php

declare(strict_types=1);

use App\Core\Database;

require dirname(__DIR__) . '/vendor/autoload.php';

$pdo = Database::connection();

$pdo->exec(
    'CREATE TABLE IF NOT EXISTS migrations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL UNIQUE,
        ran_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    )'
);

$files = glob(dirname(__DIR__) . '/database/migrations/*.sql');

if ($files === false) {
    throw new \RuntimeException('Cannot read migration files');
}

sort($files);

$findMigration = $pdo->prepare(
    'SELECT id FROM migrations WHERE migration = :migration'
);

$saveMigration = $pdo->prepare(
    'INSERT INTO migrations (migration) VALUES (:migration)'
);

foreach($files as $file) {
    $name = basename($file);

    $findMigration->execute(['migration' => $name]);

    if ($findMigration->fetchColumn() !== false) {
        echo "Skipping {$name} \n";
        continue;
    }

    $sql = file_get_contents($file);

    if ($sql === false || trim($sql) === '') {
        throw new RuntimeException("Cannot read migration: {$name}");
    }

    $pdo->exec($sql);
    $saveMigration->execute(['migration' => $name]);

    echo "Migrated {$name} \n";
}