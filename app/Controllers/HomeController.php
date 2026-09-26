<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): string
    {
        return view('home/home', ['pageTitle' => 'Hello, World!']);
    }
}
