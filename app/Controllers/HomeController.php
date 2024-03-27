<?php

namespace App\Controllers;

use App\Core\Route;

class HomeController
{
    #[Route('/', 'app.home', ['GET'])]
    public function index(): void
    {
        echo 'Page d\'accueil';
    }
}
