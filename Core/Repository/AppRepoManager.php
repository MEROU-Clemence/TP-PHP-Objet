<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\PhotoRepository;
use App\Model\Repository\AdresseRepository;
use App\Model\Repository\AnnonceRepository;
use App\Model\Repository\UtilisateurRepository;
use App\Model\Repository\TypeLogementRepository;


class AppRepoManager
{
    // on importe le trait.
    use RepositoryManagerTrait;

    // on déclare une propriété qui va contenir l'instance de la classe
    private UtilisateurRepository $utilisateurRepository;
    private AdresseRepository $adresseRepository;
    private AnnonceRepository $annonceRepository;
    private TypeLogementRepository $typelogementRepository;
    private PhotoRepository $photoRepository;

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

    // on crée le getter 
    public function getAnnonceRepo(): AnnonceRepository
    {
        return $this->annonceRepository;
    }

    // on crée le getter 
    public function getTypeLogementRepo(): TypeLogementRepository
    {
        return $this->typelogementRepository;
    }

    // on crée le getter 
    public function getPhotoRepo(): PhotoRepository
    {
        return $this->photoRepository;
    }


    // on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->utilisateurRepository = new UtilisateurRepository($config);
        $this->adresseRepository = new AdresseRepository($config);
        $this->annonceRepository = new AnnonceRepository($config);
        $this->typelogementRepository = new TypeLogementRepository($config);
        $this->photoRepository = new PhotoRepository($config);
    }
}
