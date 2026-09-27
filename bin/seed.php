<?php

declare(strict_types=1);

if (PHP_SAPI !== 'cli') {
    exit('Seeders must run from the command line.');
}

require dirname(__DIR__) . '/database/seeders/UserSeeder.php';
require dirname(__DIR__) . '/database/seeders/EventSeeder.php';
