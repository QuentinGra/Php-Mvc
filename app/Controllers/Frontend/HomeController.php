<?php

namespace App\Controllers\Frontend;

use App\Core\BaseController;
use App\Core\Route;

class HomeController extends BaseController
{
    #[Route('/', 'app.home', ['GET'])]
    public function index(): void
    {
        $this->render('Frontend/home.php');
    }
}
