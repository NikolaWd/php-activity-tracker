<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
    private static ?PDO $connection = null;

    public static function connection(): PDO
    {
        if (self::$connection === null) {
            $host = getenv('DB_HOST');
            $port = getenv('DB_PORT');
            $database = getenv('DB_DATABASE');
            $username = getenv('DB_USERNAME');
            $password = getenv('DB_PASSWORD');

            if ($host === false || $port === false || $database === false
                || $username === false || $password === false) {
                throw new \RuntimeException('Database configuration is missing');
            }

            $dsn = "mysql:host={$host};port={$port};dbname={$database};charset=utf8mb4";

            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        }

        return self::$connection;
    }
}