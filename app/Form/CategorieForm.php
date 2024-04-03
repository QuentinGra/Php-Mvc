<?php

namespace App\Form;

use App\Core\Form;
use App\Models\Categorie;

class CategorieForm extends Form
{
    public function __construct(string $action, ?Categorie $categorie = null)
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
                'value' => $categorie ? $categorie->getTitle() : null,
            ])
            ->endDiv()
            ->startDiv(['class' => 'form-check mb-3'])
            ->addLabel('enable', 'Actif', ['class' => 'form-check-label'])
            ->addInput('checkbox', 'enable', [
                'class' => 'form-check-input',
                'id' => 'enable',
                'checked' => $categorie ? $categorie->getEnable() : null,
            ])
            ->endDiv()
            ->addButton($categorie ? 'Modifier' : 'Ajouter', ['class' => 'btn btn-primary'])
            ->endForm();
    }
}
