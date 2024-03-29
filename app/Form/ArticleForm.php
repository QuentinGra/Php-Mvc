<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Article;

class ArticleForm extends Form
{
    public function __construct(string $action, ?Article $article = null)
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
                'value' => $article ? $article->getTitle() : null,
            ])
            ->endDiv()
            ->startDiv(['class' => ''])
            ->addLabel('content', 'Content', ['class' => 'form-label'])
            ->addInput('text', 'content', [
                'class' => 'form-control',
                'id' => 'content',
                'placeholder' => 'Génial',
                'required' => true,
                'value' => $article ? $article->getContent() : null,
            ])
            ->endDiv()
            ->startDiv(['class' => ''])
            ->addLabel('enable', 'Actif', ['class' => 'form-label'])
            ->addInput('checkbox', 'enable', [
                'class' => '',
                'id' => 'enable',
                'checked' => $article ? $article->getEnable() : null,
            ])
            ->endDiv()
            ->addButton('Ajouter', ['class' => 'btn btn-primary'])
            ->endForm();
    }
}
