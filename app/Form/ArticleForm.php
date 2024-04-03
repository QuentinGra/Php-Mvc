<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Article;
use App\Models\Categorie;
use App\Models\User;

class ArticleForm extends Form
{
    public function __construct(string $action, ?Article $article = null, private User $user = new User, private Categorie $categorie = new Categorie)
    {
        $this->startForm($action, 'POST', [
            'class' => 'card p-3 w-50 mx-auto',
        ])
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('title', 'Title', ['class' => 'form-label'])
            ->addInput('text', 'title', [
                'class' => 'form-control',
                'id' => 'title',
                'placeholder' => 'Super Titre',
                'required' => true,
                'value' => $article ? $article->getTitle() : null,
            ])
            ->endDiv()
            ->startDiv(['class' => 'mb-3'])
            ->addLabel('content', 'Content', ['class' => 'form-label'])
            ->addTextArea('content', [
                'class' => 'form-control',
                'id' => 'content',
                'required' => true,
            ], $article ? $article->getContent() : null)
            ->endDiv();

        if ($article) {
            $this
                ->startDiv(['class' => 'mb-3'])
                ->addLabel('user', 'Auteur', ['class' => 'form-label'])
                ->addSelect(
                    'user',
                    $this->user->findForSelect($article ? $article->getUserId() : null),
                    [
                        'class' => 'form-control',
                        'id' => 'user',
                    ]
                )
                ->endDiv()
                ->startDiv(['class' => 'mb-3'])
                ->addLabel('categorie', 'Categories', ['class' => 'form-label'])
                ->addSelect(
                    'categorie',
                    $this->categorie->findForSelect($article ? $article->getCategorieId() : null),
                    [
                        'class' => 'form-control',
                        'id' => 'categorie',
                    ]
                )
                ->endDiv();
        }
        $this->startDiv(['class' => 'form-check mb-3'])
            ->addLabel('enable', 'Actif', ['class' => 'form-check-label'])
            ->addInput('checkbox', 'enable', [
                'class' => 'form-check-input',
                'id' => 'enable',
                'checked' => $article ? $article->getEnable() : null,
            ])
            ->endDiv()
            ->addButton($article ? 'Modifier' : 'Ajouter', ['class' => 'btn btn-primary'])
            ->endForm();
    }
}
