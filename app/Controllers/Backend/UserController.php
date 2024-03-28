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
        $_SESSION['token'] = bin2hex(random_bytes(80));
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

        if ($form->validate($_POST, ['firstName', 'lastName', 'email'])) {
            $firstName = trim(strip_tags($_POST['firstName']));
            $lastName = trim(strip_tags($_POST['lastName']));
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = !empty($_POST['password']) ? password_hash($_POST['password'], PASSWORD_ARGON2I) : null;

            if ($email) {
                if ($email !== $user->getEmail() && !$this->user->findByEmail($email)) {
                    $_SESSION['messages']['danger'] = "L'email est déjà utilisé par un autre compte";
                } else {
                    $user
                        ->setFirstName($firstName)
                        ->setLastName($lastName)
                        ->setEmail($email);

                    if ($password) {
                        $user->setPassword($password);
                    }

                    $user->update();
                    $_SESSION['messages']['success'] = "User modifié avec succès";

                    $this->redirect('/admin/users');
                }
            } else {
                $_SESSION['messages']['danger'] = "Veuillez renseigner un email valide";
            }
        }

        $this->render('Backend/Users/edit.php', [
            'form' => $form->createView(),
            'user' => $user,
            'meta' => [
                'title' => "Modification de {$user->getFullName()}"
            ]
        ]);
    }

    #[Route('/admin/users/delete', 'admin.users.delete', ['POST'])]
    public function delete(): void
    {
        $user = $this->user->find(!empty($_POST['id']) ? $_POST['id'] : 0);
    }
}
