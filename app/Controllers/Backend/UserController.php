<?php

namespace App\Controllers\Backend;

use App\Core\Route;
use App\Models\User;
use App\Form\UserForm;
use App\Core\BaseController;

class UserController extends BaseController
{
    public function __construct(
        private User $user = new User
    ) {
    }

    #[Route('/admin/users', 'admin.users.index', ['GET'])]
    public function index(): void
    {
        $this->render('Backend/Users/index.php', [
            'users' => $this->user->findAll(),
            'meta' => [
                'title' => 'Administration des users',
            ]
        ]);
    }

    #[Route('/admin/users/([0-9]+)/edit', 'admin.users.edit', ['GET', 'POST'])]
    public function edit(int $id): void
    {
        $user = $this->user->find($id);

        if (!$user) {
            $_SESSION['messages']['danger'] = "User non trouvé";
            $this->redirect('/admin/users');
        }

        $form = new UserForm($_SERVER['REQUEST_URI'], $user);

        $this->render('Backend/Users/edit.php', [
            'form' => $form->createView(),
            'user' => $user,
            'meta' => [
                'title' => "Modification de {$user->getFullName()}"
            ]
        ]);
    }
}
