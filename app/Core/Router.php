<?php

declare(strict_types=1);

namespace App\Core;

class Router
{
    private array $routes = [];

    public function get(string $path, array $handler): Route
    {
        return $this->addRoute('GET', $path, $handler);
    }

    public function post(string $path, array $handler): Route
    {
        return $this->addRoute('POST', $path, $handler);
    }

    public function put(string $path, array $handler): Route
    {
        return $this->addRoute('PUT', $path, $handler);
    }

    public function patch(string $path, array $handler): Route
    {
        return $this->addRoute('PATCH', $path, $handler);
    }

    public function delete(string $path, array $handler): Route
    {
        return $this->addRoute('DELETE', $path, $handler);
    }

    private function addRoute(string $method, string $path, array $handler): Route
    {
        $route = new Route($path, $handler);
        $this->routes[$method][$path] = $route;

        return $route;
    }

    public function pathFor(string $name): string
    {
        foreach ($this->routes as $routesByMethod) {
            foreach ($routesByMethod as $route) {
                if ($route->getName() === $name) {
                    return $route->getPath();
                }
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
        
        if (!isset($this->routes[$requestMethod][$path])) {
            http_response_code(404);
            echo "404 Not Found";
            return;
        }

        $route = $this->routes[$requestMethod][$path];

        foreach ($route->getMiddlewares() as $middleware) {
            if (!$middleware->handle()) {
                return;
            }
        }

        [$controllerClass, $action] = $route->getHandler();

        $controller = new $controllerClass();

        echo $controller->$action();
    }
}
