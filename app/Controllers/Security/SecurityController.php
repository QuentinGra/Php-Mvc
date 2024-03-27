<?php

namespace App\Controllers\Security;

use App\Core\BaseController;
use App\Core\Form;
use App\Core\Route;

class SecurityController extends BaseController
{
    #[Route('/login', 'app.login', ['GET', 'POST'])]
    public function login(): void
    {
        $form = new Form;

        $form->startForm('/login', 'POST', [
            'class' => 'card p-3',
            'id' => 'form-login',
            'formnovalidate' => true
        ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email', ['class' => 'form-label required'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'john@exemple.com',
                'required' => true
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe', ['class' => 'form-label required'])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'S3CR3T',
                'required' => true
            ])
            ->endDiv()
            ->endForm();

        $this->render('Security/login.php', [
            'form' => $form->createView(),
            'meta' => [
                'title' => 'Se connecter',
            ]
        ]);
    }
}
