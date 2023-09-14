<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Adresse;
use App\Model\Utilisateur;
use App\Model\TypeLogement;

class Annonce extends Model
{
    public string $titre;
    public int $adresse_id;
    public int $utilisateur_id;
    public int $prix;
    public int $type_logement_id;
    public int $taille;
    public int $nb_pieces;
    public string $description;
    public int $nb_couchages;

    // propriétés associatives
    public ?Adresse $adresse = null;
    public ?Utilisateur $utilisateur = null;
    public ?TypeLogement $typelogement = null;
    public array $images;
    public array $equipements;

    // TODO: faire mon booléan pour activer désactiver l'annonce
    // // Par défaut, l'annonce n'est pas en pause
    // public bool $paused = false;
}
