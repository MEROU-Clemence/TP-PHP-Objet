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
// identifiants:
// - admin: doe@doe.com - mdp: doe
// - subscriber: toto@toto.com - mdp: toto

class AuthController extends Controller
{
    public const AUTH_SALT = 'c56a7523d96942a834b9cdc249bd4e8c7aa9';
    public const AUTH_PEPPER = '8d746680fd4d7cbac57fa9f033115fc52196';

    public function login()
    {
        // on va créer une instance de View pour afficher la vue de la connexion
        // on lui passe false en 2ième paramètre pour is_complete = false
        // du coup on ne chargera pas le header et le footer
        $view = new View('auth/login', false);

        $view_data = [
            'form_result' => Session::get(Session::FORM_RESULT)
        ];
        // render = méthode de la classe View qui permet d'afficher la vue
        $view->render($view_data);
    }

    // méthode qui réceptionne les données du formulaire de connexion
    public function loginPost(ServerRequest $request)
    {
        // on récupère les données du formulaire dans une variable
        $post_data = $request->getParsedBody();
        // on va créer une instance de FormResult
        $form_result = new FormResult();
        // on crée une instance de users
        $user = new Utilisateur();

        // on vérifie que les champs sont remplis
        if (empty($post_data['email']) || empty($post_data['password'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            // sinon on confronte les valeurs saisies avec les données en BDD
            // on va redéfinir des variables 
            $email = $post_data['email'];
            $password = self::hash($post_data['password']);

            // appel du repository pour vérifier que l'utilisateur existe
            // NB: on a crée méthode checkAuth dans le repository ainsi que le RepoManager
            $user = AppRepoManager::getRm()->getUserRepo()->checkAuth($email, $password);

            // si le retour est négatif, on affiche le message d'erreur
            if (is_null($user)) {
                $form_result->addError(new FormError('Email ou mot de passe incorrect'));
            }
        }

        // si il y a des erreurs, on renvoie vers la page connexion
        if ($form_result->hasError()) {
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/connexion');
        }

        // si tout s'est bien passé, on enregistre l'utilisateur en session et on redirige vers la page d'accueil.
        // on efface le mot de passe
        $user->password = '';
        Session::set(Session::USER, $user);
        // puis on redirige
        self::redirect('/');
    }

    // méthode de déconnexion
    public function logout()
    {
        // on détruit la session
        Session::remove(Session::USER);
        self::redirect('/');
    }

    // méthode de hashage du mot de passe
    public static function hash(string $password): string
    {
        return hash('sha512', self::AUTH_SALT . $password . self::AUTH_PEPPER);
    }

    public static function isAuth(): bool
    {
        return !is_null(Session::get(Session::USER));
    }

    private static function hasRole(int $role): bool
    {
        // on récupère les infos de l'utilisateur en session
        $user = Session::get(Session::USER);
        if (!($user instanceof Utilisateur)) {
            return false;
        }
        return $user->role === $role;
    }

    public static function isSubscriber(): bool
    {
        return self::hasRole(Utilisateur::ROLE_SUBSCRIBER);
    }

    public static function isAdmin(): bool
    {
        return self::hasRole(Utilisateur::ROLE_ADMINISTRATOR);
    }
}
