<?php

namespace App\Controller;

use Core\View\View;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;

class AnnonceController extends Controller
{
    public function index()
    {
        // on reconstruit notre tableau de données
        $view_data = [
            'title_tag' => 'Annonces disponibles',
            'h1_tag' => 'Annonces',
            'annonces' => AppRepoManager::getRm()->getAnnonceRepo()->findMyCompleteAnnonces()
        ];
        $view = new View('annonce/index');

        $view->render($view_data);
    }

    public function detail($id)
    {
        // on reconstruit notre tableau de données
        $view_data = [
            'title_tag' => 'Mon annonce en détail',
            'h1_tag' => 'Détails',
            'annonce' => AppRepoManager::getRm()->getAnnonceRepo()->findMyAnnonceById($id)
        ];
        $view = new View('annonce/detail');

        $view->render($view_data);
    }
}
