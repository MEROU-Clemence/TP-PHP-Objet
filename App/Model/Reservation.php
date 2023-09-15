<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Annonce;
use App\Model\Utilisateur;

class Reservation extends Model
{
    public int $annonce_id;
    public int $utilisateur_id;
    public int $date_debut;
    public int $date_fin;

    public ?Annonce $annonce = null;
    public ?Utilisateur $utilisateur = null;
}
