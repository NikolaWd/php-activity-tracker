<?php

declare(strict_types=1);

namespace App\Controllers;
use App\Core\View;

class HomeController
{
    public function index(): string
    {
        $view = new View();

        return $view->render('home', ['pageTitle' => 'Hello, World!']);
    }
}
