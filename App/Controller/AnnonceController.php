<?php

namespace App\Controller;

use Core\View\View;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Core\Form\FormResult;

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

    public function deleteAnnonce(int $id): void
    {
        // condition qui regarde si je ne suis pas un auteur
        if (!AuthController::isAuth()) self::redirect('/');

        $form_result = new FormResult();
        // Appel du repository pour supprimer l'annonce
        $user = AppRepoManager::getRm()->getAnnonceRepo()->deleteAnnonce($id);

        // s'il y a des erreurs on retourne un message
        if (!$user) {
            $form_result->addError(new FormError('Erreur lors de la suppression'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('annonce/index');
        } else {
            // sinon on redirige vers la page principale
            Session::remove(Session::FORM_RESULT, $form_result);
            self::redirect('annonce/index');
        }
    }
}
