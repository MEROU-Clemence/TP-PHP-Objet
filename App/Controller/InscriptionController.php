<?php

namespace App\Controller;

use Core\View\View;
use App\Model\Utilisateur;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

class InscriptionController extends Controller
{
    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';

    // méthode pour aller vers la création d'inscription
    public function createInscription()
    {
        // on détruit la session
        Session::remove(Session::USER);

        // on va créer une instance de View pour afficher la vue de la connexion
        // on lui passe false en 2ième paramètre pour is_complete = false
        // du coup on ne chargera pas le header et le footer
        $view = new View('auth/inscription');

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        // render = méthode de la classe View qui permet d'afficher la vue
        $view->render($view_data);
    }

    // méthode qui réceptionne les données du formulaire de connexion
    public function inscriptionPost(ServerRequest $request)
    {
        // on récupère les données du formulaire dans une variable
        $post_data = $request->getParsedBody();
        // on va créer une instance de FormResult
        $form_result = new FormResult();
        // on crée une instance de users
        $utilisateur = new Utilisateur();

        // on vérifie que les champs sont remplis
        if (
            empty($post_data['email']) ||
            empty($post_data['motdepasse']) ||
            // empty($post_data['isannonceur']) ||
            empty($post_data['rue']) ||
            empty($post_data['codepostal']) ||
            empty($post_data['ville']) ||
            empty($post_data['pays'])
        ) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/inscription');
        } else {
            // Construction du tableau de données pour Adresse
            $data_adresse = [
                'rue' => $post_data['rue'],
                'code_postal' => $post_data['codepostal'],
                'ville' => $post_data['ville'],
                'pays' => $post_data['pays']
            ];
            $adresse_id = AppRepoManager::getRm()->getAdresseRepo()->insertAdresse($data_adresse);

            // on reconstruit un tableau de données pour utilisateur
            $data_utilisateur = [
                'email' => $post_data['email'],
                'mot_de_passe' => self::hash($post_data['motdepasse']),
                'is_annonceur' => intval($post_data['isannonceur']),
                'adresse_id' => intval($adresse_id)
            ];
            $utilisateur = AppRepoManager::getRm()->getUtilisateurRepo()->checkAuthInscription($data_utilisateur);

            if (!$utilisateur) {
                $form_result->addError(new FormError('L\'utilisateur existe déjà'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/inscription');
            } else {
                $utilisateur = new Utilisateur($data_utilisateur);
                $utilisateur->mot_de_passe = '';
                Session::set(Session::USER, $utilisateur);

                // puis on redirige
                self::redirect('/');
            }
        }
    }



    // méthode de hashage du mot de passe
    public static function hash(string $motdepasse): string
    {
        return hash('sha512', self::AUTH_SALT . $motdepasse . self::AUTH_PEPPER);
    }

    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }
}
