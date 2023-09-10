<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\UtilisateurRepository;
use App\Model\Repository\AdresseRepository;


class AppRepoManager
{
    // on importe le trait.
    use RepositoryManagerTrait;

    // on déclare une propriété qui va contenir l'instance de la classe
    private UtilisateurRepository $utilisateurRepository;
    private AdresseRepository $adresseRepository;

    // on crée le getter 
    public function getUtilisateurRepo(): UtilisateurRepository
    {
        return $this->utilisateurRepository;
    }

    // on crée le getter 
    public function getAdresseRepo(): AdresseRepository
    {
        return $this->adresseRepository;
    }



    // on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->utilisateurRepository = new UtilisateurRepository($config);
        $this->adresseRepository = new AdresseRepository($config);
    }
}
