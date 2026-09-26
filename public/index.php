<?php

declare(strict_types=1);

use App\Core\Router;

require dirname(__DIR__) . '/vendor/autoload.php';

ini_set('session.use_strict_mode', '1');

session_set_cookie_params([
    'httponly' => true,
    'secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
    'samesite' => 'Lax',
]);

session_start();

$router = new Router();

require dirname(__DIR__) . '/routes/web.php';

$router->dispatch();