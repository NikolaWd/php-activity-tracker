<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): string
    {
        $viewPath = dirname(__DIR__) . '/Views/' . $view . '.php';
        if (!file_exists($viewPath)) {
            throw new \RuntimeException("View file not found: $viewPath");
        }
        extract($data, EXTR_SKIP);
        ob_start();
        require $viewPath;
        return ob_get_clean();
    }
}