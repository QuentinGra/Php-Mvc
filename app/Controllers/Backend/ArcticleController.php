<?php

namespace App\Controllers\Backend;

use App\Core\BaseController;
use App\Core\Route;
use App\Form\ArticleForm;
use App\Models\Article;

class ArcticleController extends BaseController
{
    public function __construct(
        private Article $article = new Article
    ) {
    }

    #[Route('/admin/articles', 'admin.articles.index', ['GET'])]
    public function index(): void
    {
        $_SESSION['token'] = bin2hex(random_bytes(80));
        $this->render('/Backend/Articles/index.php', [
            'articles' => $this->article->findAll(),
            'meta' => [
                'title' => 'Administration des articles',
            ]
        ]);
    }

    #[Route('/admin/articles/create', 'admin.articles.create', ['GET', 'POST'])]
    public function create(): void
    {
        $form = new ArticleForm('/admin/articles/create');

        if ($form->validate($_POST, ['title', 'content', 'enable'])) {
            $title = trim(strip_tags($_POST['title']));
            $content = trim(strip_tags($_POST['content']));
            $enable = isset($_POST) ? 1 : 0;

            (new Article)
                ->setTitle($title)
                ->setContent($content)
                ->setEnable($enable)
                ->create();

            $_SESSION['messages']['success'] = "Vous avez créé un article";
            $this->redirect('/');
        }

        $this->render('/Backend/Articles/create.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Création d\'un article',
            ]
        ]);
    }
}
