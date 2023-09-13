<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Annonce;
use App\Model\Equipement;

class AnnonceEquipement extends Model
{
    public int $annonce_id;
    public int $equipement_id;


    public ?Annonce $annonce;
    public ?Equipement $equipement;
}
