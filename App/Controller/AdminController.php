<?php

namespace App\Controller;

use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use App\Controller\AuthController;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

class AdminController extends Controller
{
    public function index(): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAdmin()) self::redirect('/');

        // on récupère la liste des utilisateurs
        // on reconstruit le tableau de données
        $view_data = [
            'title_tag' => 'Tableau de bord Airbnb',
            'h1_tag' => 'Liste des utilisateurs',
            'utilisateur' => AppRepoManager::getRm()->getUtilisateurRepo()->findAll()
        ];

        $view = new View('utilisateur/list');
        $view->render($view_data);
    }

    public function update(int $id): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAdmin()) self::redirect('/');

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'utilisateur' => AppRepoManager::getRm()->getUtilisateurRepo()->findById($id)
        ];

        $view = new View('utilisateur/update');
        $view->render($view_data);
    }

    public function updateUtilisateur(ServerRequest $request): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAdmin()) self::redirect('/');

        $post_data = $request->getParsedBody();
        $form_result = new FormResult();
        Session::remove(Session::FORM_RESULT, $form_result);

        // redéfinir nos variables sécurisées
        $email = htmlspecialchars(trim(strtolower($post_data['email'])));
        $role = intval($post_data['role']);
        $id = intval($post_data['id']);

        // si un des champs n'est pas rempli, on ajoute une erreur
        if (empty($post_data['email']) || empty($post_data['role'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/update/' . $id);
        } else {
            // Appel du repository pour mettre à jour l'utilisateur
            $user = AppRepoManager::getRm()->getUtilisateurRepo()->updateUtilisateurById($email, $role, $id);
            // si il y a des erreurs, on renoie vers la page du formulaire et on affiche les erreurs
            if ($user) {
                $form_result->addError(new FormError('Erreur lors de la mise à jour'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/admin/update/' . $id);
            } else {
                // sinon on redirige vers la page admin
                Session::remove(Session::FORM_RESULT, $form_result);
                self::redirect('/admin');
            }
        }
    }

    public function deleteUtilisateur(int $id): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAdmin()) self::redirect('/');

        $form_result = new FormResult();
        // Appel du repository pour supprimer l'utilisateur
        $user = AppRepoManager::getRm()->getUtilisateurRepo()->deleteUtilisateur($id);

        // s'il y a des erreurs on retourne un message
        if (!$user) {
            $form_result->addError(new FormError('Erreur lors de la suppression'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin');
        } else {
            // sinon on redirige vers la page admin
            Session::remove(Session::FORM_RESULT, $form_result);
            self::redirect('/admin');
        }
    }

    public function addUtilisateur(): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAdmin()) self::redirect('/');

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT),
            'title_tag' => 'Ajouter un utilisateur',
            'h1_tag' => 'Ajouter un utilisateur'
        ];

        $view = new View('utilisateur/add');
        $view->render($view_data);
    }

    public function add(ServerRequest $request): void
    {
        //condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAdmin()) self::redirect('/');

        $post_data = $request->getParsedBody();
        $form_result = new FormResult();

        if (empty($post_data['email']) || empty($post_data['password']) || empty($post_data['role'])) {

            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/admin/addUtilisateur');
        } else {
            //on récupère les données du formulaire
            $email = htmlspecialchars(trim(strtolower($post_data['email'])));
            $password = htmlspecialchars(trim($post_data['password']));
            $pass_hash = AuthController::hash($password);
            $role = intval($post_data['role']);

            //on crée un nouvel utilisateur
            $user = AppRepoManager::getRm()->getUtilisateurRepo()->createUtilisateur($email, $pass_hash, $role);

            //si l'utilisateur n'est pas créé on renvoie un message d'erreur
            if (!$user) {
                $form_result->addError(new FormError('L\'utilisateur existe déjà'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/admin/addUtilisateur');
            } else {
                //sinon on redirige vers la page admin
                Session::remove(Session::FORM_RESULT);
                self::redirect('/admin');
            }
        }
    }
}
