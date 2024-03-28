<?php

namespace App\Core;

abstract class Form
{
    /**
     * Stock le code HTML du formulaire en chaine de caractère
     *
     * @var string|null
     */
    protected ?string $formCode = null;

    /**
     * Crée la balise d'ouverture du formulaire
     *
     * @param string $method methode du formulaire (POST, GET)
     * @param string $action action du formulaire
     * @param array $attributs
     * @return Form
     */
    public function startForm(string $action, string $method, array $attributs = []): self
    {
        $this->formCode .= "<form action=\"$action\" method=\"$method\"";

        $this->formCode .= !empty($attributs) ? $this->addAttribute($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Ferme la balise HTML form
     *
     * @return self
     */
    public function endForm(): self
    {
        $this->formCode .= "</form>";

        return $this;
    }

    /**
     * Ouvre la balise div
     *
     * @param array $attributs
     * @return self
     */
    public function startDiv(array $attributs = []): self
    {
        $this->formCode .= "<div";

        $this->formCode .= !empty($attributs) ? $this->addAttribute($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Ferme la balise div
     *
     * @return self
     */
    public function endDiv(): self
    {
        $this->formCode .= "</div>";

        return $this;
    }

    /**
     * Ajoute un label
     *
     * @param string $for
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addLabel(string $for, string $text, array $attributs = []): self
    {
        $this->formCode .= "<label for=\"$for\"";

        $this->formCode .= !empty($attributs) ? $this->addAttribute($attributs) . '>' : '>';

        $this->formCode .= "$text</label>";

        return $this;
    }

    /**
     * Ajoute un input
     *
     * @param string $type
     * @param string $name
     * @param array $attributs
     * @return self
     */
    public function addInput(string $type, string $name, array $attributs = []): self
    {
        $this->formCode .= "<input type=\"$type\" name=\"$name\"";

        $this->formCode .= !empty($attributs) ? $this->addAttribute($attributs) . '>' : '>';

        return $this;
    }

    /**
     * Ajoute un bouton
     *
     * @param string $text
     * @param array $attributs
     * @return self
     */
    public function addButton(string $text, array $attributs = []): self
    {
        $this->formCode .= "<button";

        $this->formCode .= !empty($attributs) ? $this->addAttribute($attributs) . '>' : '>';

        $this->formCode .= "$text</button>";

        return $this;
    }

    /**
     * Ajoute les attributs envoyés à la balise html
     *
     * @param array $attributs Tableau associatif (['class' => 'form-control', 'required' => true])
     * @return string
     */
    public function addAttribute(array $attributs): string
    {
        $str = '';
        $attributsCourts = ['checked', 'selected', 'required', 'disabled', 'readonly', 'multiple', 'autofocus', 'novalidate', 'formnovalidate'];

        foreach ($attributs as $key => $value) {
            if (in_array($key, $attributsCourts)) {
                $str .= " $key";
            } else {
                $str .= " $key=\"$value\"";
            }
        }

        return $str;
    }

    /**
     * Validation du formulaire (si tous les champs sont remplis)
     *
     * @param array $form Tableau issu du formulaire ($_POST || $_GET)
     * @param array $champs Tableau listant les champs obligatoires
     * @return bool
     */
    public function validate(array $form, array $champs): bool
    {
        // On boucle sur le tableau de champs obligatoire
        foreach ($champs as $champ) {
            // On vérifie si les champs obligatoires sont null
            if (empty($form[$champ]) || strlen(trim($form[$champ])) === 0) {
                // Si oui, on retourne false car le formulaire n'est pas valide 
                return false;
            }
        }

        // Le formulaire est valide on envoie true
        return true;
    }

    /**
     * Renvoie le code HTML du formulaire en format string
     *
     * @return string
     */
    public function createView(): string
    {
        return $this->formCode;
    }
}
