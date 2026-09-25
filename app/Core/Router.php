<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $getRoutes = [];

    public function get(string $path, array $handler): void
    {
        $this->getRoutes[$path] = $handler;
    }

    public function dispatch(): void
    {
        $requestMethod = $_SERVER['REQUEST_METHOD'] ?? 'GET';

        $path = parse_url(
                $_SERVER['REQUEST_URI'] ?? '/', 
                PHP_URL_PATH
            ) ?? '/';
        
        if ($requestMethod !== 'GET' || !isset($this->getRoutes[$path])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        [$controllerClass, $action] = $this->getRoutes[$path];

        $controller = new $controllerClass();

        echo $controller->$action();
    }
}