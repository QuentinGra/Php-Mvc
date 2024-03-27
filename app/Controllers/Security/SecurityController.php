<?php

namespace App\Controllers\Security;

use App\Core\BaseController;
use App\Core\Route;
use App\Form\LoginForm;
use App\Models\User;

class SecurityController extends BaseController
{
    #[Route('/login', 'app.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new LoginForm('/login');

        if ($form->validate($_POST, ['email', 'password'])) {
            $user = (new User)->findByEmail($_POST['email']);

            var_dump($user);
        }

        $this->render('Security/login.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Se connecter',
            ]
        ]);
    }
}
