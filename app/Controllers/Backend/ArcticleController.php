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

        if ($form->validate($_POST, ['title', 'content'])) {
            $title = trim(strip_tags($_POST['title']));
            $content = trim(strip_tags($_POST['content']));
            $enable = isset($_POST['enable']) ? 1 : 0;

            (new Article)
                ->setTitle($title)
                ->setContent($content)
                ->setEnable($enable)
                ->create();

            $_SESSION['messages']['success'] = "Vous avez créé un article";
            $this->redirect('/admin/articles');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['danger'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('/Backend/Articles/create.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Création d\'un article',
            ]
        ]);
    }

    #[Route('/admin/articles/([0-9]+)/edit', 'admin.articles.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $article = $this->article->find($id);

        if (!$article) {
            $_SESSION['messages']['danger'] = "Article non trouvé";
            $this->redirect('/admin/articles');
        }

        $form = new ArticleForm($_SERVER['REQUEST_URI'], $article);

        if ($form->validate($_POST, ['title', 'content'])) {
            $title = trim(strip_tags($_POST['title']));
            $content = trim(strip_tags($_POST['content']));
            $enable = isset($_POST['enable']) ? 1 : 0;

            $article
                ->setTitle($title)
                ->setContent($content)
                ->setEnable($enable)
                ->update();

            $_SESSION['messages']['success'] = "Article modifié avec succès";
            $this->redirect('/admin/articles');
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['danger'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Backend/Articles/edit.php', [
            'form' => $form->createView(),
            'article' => $article,
            'meta' => [
                'title' => "Modification de {$article->getTitle()}"
            ]
        ]);
    }
}
