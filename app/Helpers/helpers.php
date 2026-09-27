<?php

if(!function_exists('view')) {
    function view($view, $data = []) 
    {
        $viewPath = __DIR__ . '/../../views/' . $view . '.php';

        if (!file_exists($viewPath)) {
            throw new InvalidArgumentException("View not found: {$view}");
        }

        extract($data, EXTR_SKIP);

        ob_start();
        require $viewPath;

        return ob_get_clean();
    }
}

if(!function_exists('route')) {
    function route(string $name): string
    {
        global $router;

        if(!$router instanceof \App\Core\Router) {
            throw new \RuntimeException("Router instance not found.");
        }

        return $router->pathFor($name);
    }
}

if (!function_exists('auth')) {
    function auth(): ?\App\Models\User
    {
        return \App\Core\Auth::user();
    }
}

if (!function_exists('csrf_token')) {
    function csrf_token(): string
    {
        if (!isset($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('valid_csrf_token')) {
    function valid_csrf_token(): bool
    {
        $token = $_POST['csrf_token'] ?? null;

        return is_string($token)
            && isset($_SESSION['csrf_token'])
            && is_string($_SESSION['csrf_token'])
            && hash_equals($_SESSION['csrf_token'], $token);
    }
}

if (!function_exists('e')) {
    function e(string|int|float|null $value): string
    {
        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
