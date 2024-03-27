<?php

namespace App\Controllers\Frontend;

use App\Core\BaseController;
use App\Core\Route;
use App\Models\Article;

class ArticleController extends BaseController
{
    #[Route('/articles/details/([0-9]+)', 'app.articles.show', ['GET'])]
    public function show(int $id): void
    {
        $article = (new Article)->find($id);

        $this->render('Frontend/Articles/show.php');
    }
}
