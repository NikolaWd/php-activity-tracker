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