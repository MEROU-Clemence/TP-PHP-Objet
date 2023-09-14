<?php

namespace App\Controller;

use Core\View\View;
use App\Model\Annonce;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use App\Model\Utilisateur;
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
        $view = new View('auth/login');

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
        $utilisateur = new Utilisateur();

        // on vérifie que les champs sont remplis
        if (empty($post_data['email']) || empty($post_data['motdepasse'])) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
        } else {
            // sinon on confronte les valeurs saisies avec les données en BDD
            // on va redéfinir des variables 
            $email = $post_data['email'];
            $motdepasse = self::hash($post_data['motdepasse']);

            // appel du repository pour vérifier que l'utilisateur existe
            // NB: on a crée méthode checkAuth dans le repository ainsi que le RepoManager
            $utilisateur = AppRepoManager::getRm()->getUtilisateurRepo()->checkAuth($email, $motdepasse);

            // si le retour est négatif, on affiche le message d'erreur
            if (is_null($utilisateur)) {
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
        $utilisateur->motdepasse = '';
        Session::set(Session::USER, $utilisateur);
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

    // méthode pour ajouter un annonce
    public function addAnnonce()
    {
        // on va créer une instance de View pour afficher la vue de la connexion
        // on lui passe false en 2ième paramètre pour is_complete = false
        // du coup on ne chargera pas le header et le footer
        $view = new View('annonce/addannonce');

        $view_data = [
            'title_tag' => 'Ajouter une annonce',
            'h1_tag' => 'Ajouter une annonce',
            'form_result' => Session::get(Session::FORM_RESULT),
            'typeslogement' => AppRepoManager::getRm()->getTypeLogementRepo()->findAll(),
            'equipements' => AppRepoManager::getRm()->getEquipementRepo()->findAll()


        ];
        // render = méthode de la classe View qui permet d'afficher la vue
        $view->render($view_data);
    }

    // méthode qui réceptionne les données du formulaire de connexion
    public function annoncePost(ServerRequest $request)
    {
        // on récupère les données du formulaire dans une variable
        $post_data = $request->getParsedBody();
        // on va créer une instance de FormResult
        $form_result = new FormResult();
        // on crée une instance de users
        $newannonce = new Annonce();
        // instance d'images
        $image_data = $_FILES['images'];

        var_dump($post_data);


        // condition pour restreindre les types de fichiers que l'on souhaite recevoir
        // Récupérer l'utilisateur connecté depuis la session
        $utilisateurConnecte = Session::get(Session::USER);


        // condition pour que l'utilisateur connecté ne puisse pas renseigner d'autre adresse email que la sienne, comparez l'adresse email saisie dans le formulaire avec celle de l'utilisateur connecté
        if ($post_data['email'] !== $utilisateurConnecte->email) {
            $form_result->addError(new FormError('Vous ne pouvez pas renseigner une adresse email différente de la vôtre.'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/addannonce');
        } else if (
            $image_data['type'] !== 'image/jpeg' &&
            $image_data['type'] !== 'image/png' &&
            $image_data['type'] !== 'image/jpg' &&
            $image_data['type'] !== 'image/webp'
        ) {
            $form_result->addError(new FormError('Le format de l\'image n\'est pas valide'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/addannonce');
        } else if (
            // on vérifie que les champs sont remplis
            empty($post_data['titre']) ||
            empty($post_data['description']) ||
            empty($post_data['rue']) ||
            empty($post_data['codepostal']) ||
            empty($post_data['ville']) ||
            empty($post_data['pays']) ||
            empty($post_data['prix']) ||
            empty($post_data['taille']) ||
            empty($post_data['type_logement']) ||
            empty($post_data['pieces']) ||
            empty($post_data['couchages']) ||
            empty($post_data['email'])
        ) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/addannonce');
        } else {


            // Construction du tableau de données pour Adresse
            $data_adresse = [
                'rue' => $post_data['rue'],
                'code_postal' => $post_data['codepostal'],
                'ville' => $post_data['ville'],
                'pays' => $post_data['pays']
            ];
            $adresse_id = AppRepoManager::getRm()->getAdresseRepo()->insertAdresse($data_adresse);

            // Session pour mon email
            $utilisateur_id = Session::get(Session::USER)->id;

            // construction tableau pour l'ajout Annonce
            $data_annonce = [
                'titre' => $post_data['titre'],
                'adresse_id' => intval($adresse_id),
                'utilisateur_id' => intval($utilisateur_id),
                'prix' => intval($post_data['prix']),
                'type_logement_id' => intval($post_data['type_logement']),
                'taille' => intval($post_data['taille']),
                'nb_pieces' => intval($post_data['pieces']),
                'description' => $post_data['description'],
                'nb_couchages' => intval($post_data['couchages'])
            ];
            $annonce_id = AppRepoManager::getRm()->getAnnonceRepo()->insertAnnonce($data_annonce);

            // on traite l'image
            // le chemin de la source (sur le serveur)
            $imgTmpPath = $image_data['tmp_name'];
            // on redéfini un nom unique pour l'image
            $filename = uniqid() . '_' . $image_data['name'];
            // le chemin de destination
            $imgPathPublic = PATH_ROOT . '/public/img/' . $filename;

            // Construction du tableau de données pour Photo
            $data_photo = [
                'image_path' => $filename,
                'annonce_id' => intval($annonce_id)
            ];

            // on va déplacer le fichier tmp dans son dossier de destination dans une condition
            if (move_uploaded_file($imgTmpPath, $imgPathPublic)) {
                // appel du Repository pour insérer dans la BDD
                AppRepoManager::getRm()->getPhotoRepo()->insertPhotos($data_photo);
            } else {
                $form_result->addError(new FormError('Erreur lors de l\'upload de l\'image'));
            }

            // appel du Repo pour insérer les equipements dans annonces equipement dans la BDD
            AppRepoManager::getRm()->getAnnonceEquipementRepo()->insertEquipement($post_data['equipement'], $annonce_id);


            // on redirige
            self::redirect('/');
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
