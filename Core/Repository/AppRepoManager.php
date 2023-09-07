<?php

namespace Core\Repository;

use Core\App;

class AppRepoManager
{
    // on déclare une propriété qui va contenir l'instance de la classe

    // on importe le trait.
    use RepositoryManagerTrait;

    // on crée le getter 



    // on déclare le constructeur
    protected function __construct()
    {
        $config = App::getApp();
    }
}
