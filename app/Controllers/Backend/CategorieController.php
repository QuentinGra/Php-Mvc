<?php

namespace App\Controllers\Backend;

use DateTime;
use App\Core\Route;
use App\Models\Categorie;
use App\Form\CategorieForm;
use App\Core\BaseController;

class CategorieController extends BaseController
{
    public function __construct(
        private Categorie $categorie = new Categorie
    ) {
    }

    #[Route('/admin/categories', 'admin/categories', ['GET'])]
    public function index(): void
    {
        $_SESSION['token'] = bin2hex(random_bytes(80));
        $this->render('/Backend/Categories/index.php', [
            'categories' => $this->categorie->findAll(),
            'meta' => [
                'title' => 'Administration des catégories',
            ]
        ]);
    }

    #[Route('/admin/categories/create', 'admin.categories.create', ['GET', 'POST'])]
    public function create(): void
    {
        $form = new CategorieForm('/admin/categories/create');

        if ($form->validate($_POST, ['title'])) {
            $title = trim(strip_tags($_POST['title']));
            $enable = isset($_POST['enable']) ? 1 : 0;

            if (!$this->categorie->findOneBy(['title' => $title])) {
                $this->categorie
                    ->setTitle($title)
                    ->setEnable($enable)
                    ->setCreatedAt(new DateTime())
                    ->create();

                $_SESSION['messages']['success'] = "Vous avez créé une categorie";
                $this->redirect('/admin/categories');
            } else {
                $_SESSION['messages']['danger'] = "Ce titre existe déjà";
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['danger'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('/Backend/Categories/create.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Création d\'une categorie',
            ]
        ]);
    }

    #[Route('/admin/categories/([0-9]+)/edit', 'admin.categories.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $categorie = $this->categorie->find($id);

        if (!$categorie) {
            $_SESSION['messages']['danger'] = "Catégorie non trouvé";
            $this->redirect('/admin/categories');
        }

        $form = new CategorieForm($_SERVER['REQUEST_URI'], $categorie);

        if ($form->validate($_POST, ['title'])) {
            $title = trim(strip_tags($_POST['title']));
            $enable = isset($_POST['enable']) ? 1 : 0;

            if ($title !== $categorie->getTitle() && !$this->categorie->findOneBy(['title' => $title])) {
                $_SESSION['messages']['danger'] = "Ce titre est déjà dans la db";
            } else {
                $this->categorie
                    ->setTitle($title)
                    ->setEnable($enable)
                    ->setUpdatedAt(new DateTime())
                    ->update();

                $this->redirect('/admin/categories');
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['danger'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('/Backend/Categories/edit.php', [
            'form' => $form->createView(),
            'categorie' => $categorie,
            'meta' => [
                'title' => 'Modification d\'une categorie',
            ]
        ]);
    }
}
