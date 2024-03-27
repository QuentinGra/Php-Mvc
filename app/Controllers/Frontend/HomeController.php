<?php

namespace App\Controllers\Frontend;

use App\Core\Route;

class HomeController
{
    #[Route('/', 'app.home', ['GET'])]
    public function index(): void
    {
        require_once ROOT . '/Views/Frontend/home.php';
    }
}
