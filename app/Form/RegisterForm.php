<?php

namespace App\Form;

use App\Core\Form;

class RegisterForm extends Form
{
    public function __construct(string $action)
    {
        $this->startForm($action, 'POST', [
            'class' => 'card p-3 w-75 mx-auto',
            'id' => 'register-form',
        ])
            ->startDiv(['class' => 'row mb-3'])
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('firstName', 'Prénom', ['class' => 'form-label'])
            ->addInput('text', 'firstName', [
                'class' => 'form-control',
                'id' => 'firstName',
                'placeholder' => 'John',
                'required' => true
            ])
            ->endDiv()
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('lastName', 'Nom', ['class' => 'form-label'])
            ->addInput('text', 'lastName', [
                'class' => 'form-control',
                'id' => 'lastName',
                'placeholder' => 'Doe',
                'required' => true
            ])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email', ['class' => 'form-label'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'john@example.com',
                'required' => true
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe', ['class' => 'form-label'])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'S3CR3T',
                'required' => true
            ])
            ->endDiv()
            ->addButton('S\'inscrire', ['class' => 'btn btn-primary'])
            ->endForm();
    }
}
