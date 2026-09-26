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