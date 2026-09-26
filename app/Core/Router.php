<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $getRoutes = [];

    public function get(string $path, array $handler): Route
    {
        $route = new Route($path, $handler);
        
        $this->getRoutes[$path] = $route;

        return $route;
    }

    public function pathFor(string $name): string
    {
        foreach ($this->getRoutes as $route) {
            if ($route->getName() === $name) {
                return $route->getPath();
            }
        }

        throw new \InvalidArgumentException(
            "Route with name '{$name}' not found."
        );
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

        $route = $this->getRoutes[$path];
        [$controllerClass, $action] = $route->getHandler();

        $controller = new $controllerClass();

        echo $controller->$action();
    }
}