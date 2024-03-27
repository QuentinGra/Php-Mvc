<?php

namespace App\Controllers\Frontend;

use App\Core\Route;

class ArticleController
{
    #[Route('/article/details/([0-9]+)', 'app.articles.show', ['GET'])]
    public function show(int $id): void
    {
        echo "Page de détails de l'article $id";
    }
}
