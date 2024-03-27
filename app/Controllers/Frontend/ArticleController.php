<?php

namespace App\Controllers\Frontend;

use App\Core\Route;
use App\Models\Article;

class ArticleController
{
    #[Route('/articles/details/([0-9]+)', 'app.articles.show', ['GET'])]
    public function show(int $id): void
    {
        $article = (new Article)->find($id);

        var_dump($article);
    }
}
