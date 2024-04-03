<?php

namespace App\Controllers\Backend;

use DateTime;
use App\Core\Route;
use App\Models\Article;
use App\Form\ArticleForm;
use App\Core\BaseController;

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
                'js' => [
                    '/assets/js/switchArticle.js',
                ]
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

            if (!$this->article->findOneBy(['title' => $title])) {
                $this->article
                    ->setTitle($title)
                    ->setContent($content)
                    ->setEnable($enable)
                    ->setCreatedAt(new DateTime())
                    ->setUserId($_SESSION['user']['id'])
                    ->create();

                $_SESSION['messages']['success'] = "Vous avez créé un article";
                $this->redirect('/admin/articles');
            } else {
                $_SESSION['messages']['danger'] = "Ce titre existe déjà";
            }
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

        if ($form->validate($_POST, ['title', 'content', 'user'])) {
            $title = trim(strip_tags($_POST['title']));
            $content = trim(strip_tags($_POST['content']));
            $enable = isset($_POST['enable']) ? 1 : 0;
            $userId = $_POST['user'];

            if ($title !== $article->getTitle() && !$this->article->findOneBy(['title' => $title])) {
                $_SESSION['messages']['danger'] = "Ce titre est déjà utilisé par un autre article";
            } else {
                $article
                    ->setTitle($title)
                    ->setContent($content)
                    ->setEnable($enable)
                    ->setUpdatedAt(new DateTime)
                    ->setUserId($userId)
                    ->update();

                $_SESSION['messages']['success'] = "Article modifié avec succès";
                $this->redirect('/admin/articles');
            }
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

    #[Route('/admin/articles/delete', 'admin.articles.delete', ['POST'])]
    public function delete(): void
    {
        $article = $this->article->find(!empty($_POST['id']) ? $_POST['id'] : 0);

        if (!$article) {
            $_SESSION['messages']['danger'] = "Article pas trouvé";
            $this->redirect('/admin/articles');
        }

        if (hash_equals($_SESSION['token'], !empty($_POST['token']) ? $_POST['token'] : '')) {
            $article->delete();

            $_SESSION['messages']['success'] = "Article supprimé avec succès";
        } else {
            $_SESSION['messages']['danger'] = "Invalide token CSRF";
        }

        $this->redirect('/admin/articles');
    }

    #[Route('/admin/articles/([0-9]+)/switch', 'admin.articles.switch', ['GET'])]
    public function switch(int $id): void
    {
        header('Content-Type:application/json');
        $article = $this->article->find($id);

        if (!$article) {
            http_response_code(404);
            echo json_encode([
                'status' => 404,
                'message' => 'Article non trouvé',
            ]);
            exit();
        }

        $article
            ->setEnable(!$article->getEnable())
            ->setUpdatedAt(new DateTime())
            ->update();

        http_response_code(201);
        echo json_encode([
            'status' => 201,
            'message' => 'Visibility changed',
            'enable' => (bool) $article->getEnable(),
        ]);
    }
}
