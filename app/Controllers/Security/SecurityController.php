<?php

namespace App\Controllers\Security;

use App\Core\Route;
use App\Models\User;
use App\Form\LoginForm;
use App\Form\RegisterForm;
use App\Core\BaseController;

class SecurityController extends BaseController
{
    #[Route('/login', 'app.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new LoginForm('/login');

        if ($form->validate($_POST, ['email', 'password'])) {
            $user = (new User)->findByEmail($_POST['email']);

            if ($user && password_verify($_POST['password'], $user->getPassword())) {
                $user->login();

                $this->redirect('/');
            } else {
                $_SESSION['messages']['danger'] = "Identifiants invalides";
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['danger'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Security/login.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Se connecter',
            ]
        ]);
    }

    #[Route('/logout', 'app.logout', ['GET'])]
    public function logout(): void
    {
        if (!empty($_SESSION['user'])) {
            unset($_SESSION['user']);
        }

        $this->redirect('/');
    }

    #[Route('/register', 'app.register', ['GET', 'POST'])]
    public function register(): void
    {
        $form = new RegisterForm('/register');

        if ($form->validate($_POST, ['firstName', 'lastName', 'email', 'password'])) {
            $firstName = trim(strip_tags($_POST['firstName']));
            $lastName = trim(strip_tags($_POST['lastName']));
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            $password = password_hash($_POST['password'], PASSWORD_ARGON2I);

            if ($email) {
                if (!(new User)->findByEmail($email)) {
                    (new User)
                        ->setFirstName($firstName)
                        ->setLastName($lastName)
                        ->setEmail($email)
                        ->setPassword($password)
                        ->create();

                    $_SESSION['messages']['success'] = "Vous êtes bien inscrit à l'application";
                    $this->redirect('/');
                } else {
                    $_SESSION['messages']['danger'] = "L'email est déja utilisé par un autre compte";
                }
            } else {
                $_SESSION['messages']['danger'] = "Veuillez renseigner un email valide";
            }
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $_SESSION['messages']['danger'] = "Veuillez remplir tous les champs obligatoires";
        }

        $this->render('Security/register.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Inscription',
            ]
        ]);
    }
}
