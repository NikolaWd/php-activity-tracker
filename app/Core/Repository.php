<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Repository
{
    protected PDO $pdo;

    public function __construct()
    {
        $this->pdo = Database::connection();
    }
}