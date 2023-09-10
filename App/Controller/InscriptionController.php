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
        if (empty($post_data['email']) || empty($post_data['motdepasse']) || empty($post_data['isannonceur']) || empty($post_data['rue']) || empty($post_data['codepostal']) || empty($post_data['ville']) || empty($post_data['pays'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            // sinon on confronte les valeurs saisies avec les données en BDD
            // on va redéfinir des variables 
            $email = $post_data['email'];
            $motdepasse = self::hash($post_data['motdepasse']);
            $isannonceur = ($post_data['isannonceur'] == 'oui');
            $rue = $post_data['rue'];
            $codepostal = $post_data['codepostal'];
            $ville = $post_data['ville'];
            $pays = $post_data['pays'];


            // appel du repository pour vérifier que l'utilisateur existe
            // NB: on a crée méthode checkAuth dans le repository ainsi que le RepoManager
            $utilisateur = AppRepoManager::getRm()->getUtilisateurRepo()->checkAuthInscription($email, $motdepasse, $isannonceur, $rue, $codepostal, $ville, $pays);

            // si le retour est négatif, on affiche le message d'erreur
            if (is_null($utilisateur)) {
                $form_result->addError(new FormError('Un ou plusieurs champs sont incorrects'));
            }
        }

        // si il y a des erreurs, on renvoie vers la page d'inscription
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/inscription');
        }

        // si tout s'est bien passé, on enregistre l'utilisateur en session et on redirige vers la page de connexion.
        // on efface le mot de passe
        $utilisateur->motdepasse = '';
        Session::set(Session::USER, $utilisateur);

        // puis on redirige
        self::redirect('/connexion');
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
