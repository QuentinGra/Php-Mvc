<?php

namespace App\Form;

use App\Core\Form;
use App\Models\User;

class UserForm extends Form
{
    public function __construct(string $action, ?User $user = null)
    {
        $this->startForm($action, 'POST', [
            'class' => 'card p-3 w-75 mx-auto',
            'id' => 'user-form',
        ])
            ->startDiv(['class' => 'row mb-3'])
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('firstName', 'Prénom', ['class' => 'form-label'])
            ->addInput('text', 'firstName', [
                'class' => 'form-control',
                'id' => 'firstName',
                'placeholder' => 'John',
                'required' => true,
                'value' => $user ? $user->getFirstName() : null,
            ])
            ->endDiv()
            ->startDiv(['class' => 'col-md-6'])
            ->addLabel('lastName', 'Nom', ['class' => 'form-label'])
            ->addInput('text', 'lastName', [
                'class' => 'form-control',
                'id' => 'lastName',
                'placeholder' => 'Doe',
                'required' => true,
                'value' => $user ? $user->getLastName() : null,
            ])
            ->endDiv()
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('email', 'Email', ['class' => 'form-label'])
            ->addInput('email', 'email', [
                'class' => 'form-control',
                'id' => 'email',
                'placeholder' => 'john@example.com',
                'required' => true,
                'value' => $user ? $user->getEmail() : null,
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('password', 'Mot de passe', ['class' => 'form-label'])
            ->addInput('password', 'password', [
                'class' => 'form-control',
                'id' => 'password',
                'placeholder' => 'S3CR3T',
                'required' => $user ? false : true,
            ])
            ->endDiv()
            ->addButton($user ? 'Modifier' : 'S\'inscrire', ['class' => 'btn btn-primary'])
            ->endForm();
    }
}
