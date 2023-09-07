<?php

namespace Core\Form;

use Core\Form\FormError;

class FormResult
{
    // on crée un tableau pour stocker les erreurs
    private array $form_errors = [];
    // on déclare le constructeur avec un paramètre par défaut
    public function __construct(private string $sucess_message = '')
    {
    }

    // on crée son getter
    public function getSuccessMessage(): string
    {
        return $this->sucess_message;
    }

    public function getErrors(): array
    {
        return $this->form_errors;
    }

    // on crée une méthode qui permet de savoir si on a des erreurs
    public function hasError(): bool
    {
        return !empty($this->form_errors);
    }
    // on crée un tableau pour stocker les erreurs
    public function addError(FormError $error)
    {
        $this->form_errors[] = $error;
    }
}
