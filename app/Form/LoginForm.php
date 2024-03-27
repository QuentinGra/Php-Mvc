<?php

namespace App\Form;

use App\Core\Form;

class LoginForm extends Form
{
    public function __construct()
    {
        $this->startForm('/login', 'POST', [
            'class' => 'card p-3 w-50 mx-auto',
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
    }
}
