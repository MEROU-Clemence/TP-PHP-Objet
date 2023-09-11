<?php

namespace App\Model;

use DateTime;
use Core\Model\Model;
use App\Model\Annonce;
use App\Model\Utilisateur;

class Reservation extends Model
{
    public int $annonce_id;
    public int $utilisateur_id;
    public DateTime $date_debut;
    public DateTime $date_fin;

    public ?Annonce $annonce = null;
    public ?Utilisateur $utilisateur = null;
}
