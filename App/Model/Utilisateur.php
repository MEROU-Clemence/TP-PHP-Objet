<?php

namespace App\Model;

use Core\Model\Model;

class Utilisateur extends Model
{
    public const ROLE_SUBSCRIBER = 1;
    public const ROLE_ADMINISTRATOR = 2;

    public string $email;
    public string $mot_de_passe;
    public bool $is_annonceur;
    public int $adresse_id;

    public ?Adresse $adresse = null;
}
