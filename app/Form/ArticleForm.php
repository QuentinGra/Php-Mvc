<?php

namespace App\Form;

use App\Core\Form;

class ArticleForm extends Form
{
    public function __construct(string $action)
    {
        $this->startForm($action, 'POST', [
            'class' => 'card p-3 w-50 mx-auto',
        ])
            ->startDiv(['class' => ''])
            ->addLabel('title', 'Title', ['class' => 'form-label'])
            ->addInput('text', 'title', [
                'class' => 'form-control',
                'id' => 'title',
                'placeholder' => 'Super Titre',
                'required' => true,
            ])
            ->endDiv()
            ->startDiv(['class' => ''])
            ->addLabel('content', 'Content', ['class' => 'form-label'])
            ->addInput('text', 'content', [
                'class' => 'form-control',
                'id' => 'content',
                'placeholder' => 'Génial',
                'required' => true,
            ])
            ->endDiv()
            ->startDiv(['class' => ''])
            ->addLabel('enable', 'Actif', ['class' => 'form-label'])
            ->addInput('checkbox', 'enable', [
                'class' => '',
                'id' => 'enable',
            ])
            ->endDiv()
            ->addButton('Ajouter', ['class' => 'btn btn-primary'])
            ->endForm();
    }
}
