<?php

namespace Core\Repository;

use Core\App;
use App\Model\Repository\UtilisateurRepository;


class AppRepoManager
{
    // on importe le trait.
    use RepositoryManagerTrait;

    // on déclare une propriété qui va contenir l'instance de la classe
    private UtilisateurRepository $utilisateurRepository;

    // on crée le getter 
    public function getUtilisateurRepo(): UtilisateurRepository
    {
        return $this->utilisateurRepository;
    }


    // on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
        $this->utilisateurRepository = new UtilisateurRepository($config);
    }
}
