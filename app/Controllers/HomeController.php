<?php

declare(strict_types=1);

namespace App\Controllers;

class HomeController
{
    public function index(): string
    {
        return view('home/home', ['pageTitle' => 'Hello, World!']);
    }

    public function about(): string
    {
        return view('home/about', ['pageTitle' => 'About Us']);
    }
}
