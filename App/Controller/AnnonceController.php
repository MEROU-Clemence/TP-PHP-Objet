<?php

namespace App\Controller;

use Core\View\View;
use Core\Form\FormError;
use Core\Form\FormResult;
use Core\Session\Session;
use Core\Controller\Controller;
use Core\Repository\AppRepoManager;
use Laminas\Diactoros\ServerRequest;

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

    public function editAnnonce(int $id): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAuth()) self::redirect('/');

        $view_data = [
            'title_tag' => 'Modifier l\'annonce',
            'h1_tag' => 'Modifier l\'annonce',
            'annonce' => AppRepoManager::getRm()->getAnnonceRepo()->findMyAnnonceById($id),
            'form_result' => Session::get(Session::FORM_RESULT),
            'typeslogement' => AppRepoManager::getRm()->getTypeLogementRepo()->findAll(),
            'equipements' => AppRepoManager::getRm()->getEquipementRepo()->findAll()

        ];
        $view = new View('annonce/updateannonce');
        $view->render($view_data);
    }

    public function updateAnnonce(ServerRequest $request): void
    {
        // condition qui regarde si je ne suis pas un admin
        if (!AuthController::isAuth()) self::redirect('/');

        $post_data = $request->getParsedBody();

        $form_result = new FormResult();
        // on déclare nos variables de $post_data
        $id = intval($post_data['id']);
        $titre = htmlspecialchars(trim($post_data['titre']));
        $adresse_id = intval($post_data['adresse_id']);
        $rue = htmlspecialchars(trim($post_data['rue']));
        $codepostal = htmlspecialchars(trim($post_data['codepostal']));
        $ville = htmlspecialchars(trim($post_data['ville']));
        $pays = htmlspecialchars(trim($post_data['pays']));
        $utilisateur_id = intval($post_data['utilisateur_id']);
        $prix = intval($post_data['prix']);
        $type_logement_id = intval($post_data['type_logement_id']);
        $taille = intval($post_data['taille']);
        $nb_pieces = intval($post_data['pieces']);
        $description = htmlspecialchars(trim($post_data['description']));
        $nb_couchages = intval($post_data['couchages']);
        // conditions pour savoir si on a uploadé une image
        if (empty($_FILES['image']['tmp_name'])) {
            // on reconstruit un tableau de données sans les infos de l'annonce
            $data = [
                'titre' => $titre,
                'adresse_id' => $adresse_id,
                'utilisateur_id' => $utilisateur_id,
                'prix' => $prix,
                'type_logement_id' => $type_logement_id,
                'taille' => $taille,
                'nb_pieces' => $nb_pieces,
                'description' => $description,
                'nb_couchages' => $nb_couchages,
                'id' => $id
            ];

            // on reconstruit un tableau de données sans les infos de l'adresse
            $data_adresse = [
                'id' => $adresse_id,
                'rue' => $rue,
                'code_postal' => $codepostal,
                'ville' => $ville,
                'pays' => $pays
            ];

            // Appeler le Repository pour mettre à jour l'annonce
            AppRepoManager::getRm()->getAnnonceRepo()->update($data);

            // pour adresse update
            AppRepoManager::getRm()->getAdresseRepo()->update($data_adresse);


            // Equipement par annonce hydratation
            // Récupérez les nouveaux équipements sélectionnés par l'utilisateur
            $nouveauxEquipements = $post_data['equipement'];
            // Equipements: Supprimez tous les équipements existants associés à l'annonce
            AppRepoManager::getRm()->getAnnonceEquipementRepo()->deleteByAnnonceId($id);
            // Insérez les équipements dans la table de liaison "AnnonceEquipement"
            AppRepoManager::getRm()->getAnnonceEquipementRepo()->insertEquipement($nouveauxEquipements, $id);
        } else {
            // ICI ON PREND LE CAS OU ON A UPLOADE UNE IMAGE
            // on reconstruit un tableau de données avec les infos de l'image
            $image_data = $_FILES['image'];

            // on récupère le dossier source (tmp_name)
            $imgTmpPath = $image_data['tmp_name'];
            // on reconstruit le nom du fichier unique
            $filename = uniqid() . '_' . $image_data['name'];
            // on reconstruit le chemin de la destination
            $imgPathPublic = PATH_ROOT . '/public/img/' . $filename;

            // on reconstruit un tableau de données avec les infos de l'image
            $data = [
                'titre' => $titre,
                'adresse_id' => $adresse_id,
                'utilisateur_id' => $utilisateur_id,
                'prix' => $prix,
                'type_logement_id' => $type_logement_id,
                'taille' => $taille,
                'nb_pieces' => $nb_pieces,
                'description' => $description,
                'nb_couchages' => $nb_couchages,
                'image' => $filename,
                'id' => $id
            ];
            // appeler le Repository pour mettre à jour l'Annonce après avoir vérifié que l'on a move le fichier
            if (move_uploaded_file($imgTmpPath, $imgPathPublic)) {
                // Appeler le Repository pour mettre à jour l'annonce
                AppRepoManager::getRm()->getAnnonceRepo()->update($data);
            } else {
                echo 'La modification n\'a pas marchée';
            };
        }

        // si on a des erreurs
        if ($form_result->hasError()) {
            // on stocke les erreurs dans la session
            Session::set(Session::FORM_RESULT, $form_result);
            // on redirige vers la page d'ajout d'annonce
            self::redirect('/annonce/updateannonce/' . $id);
        }
        // sinon on redirige vers la page admin
        Session::remove(Session::FORM_RESULT);
        self::redirect('/');
    }

    public function reserverAnnonce($id)
    {
        // on reconstruit notre tableau de données
        $view_data = [
            'title_tag' => 'Réserver un logement',
            'h1_tag' => 'Réserver un logement',
            'form_result' => Session::get(Session::FORM_RESULT),
            'annonce' => AppRepoManager::getRm()->getAnnonceRepo()->findMyAnnonceById($id)
        ];
        $view = new View('annonce/reserver');

        $view->render($view_data);
    }

    public function reserverPost(ServerRequest $request)
    {
        // on récupère les données du formulaire dans une variable
        $post_data = $request->getParsedBody();

        // on va créer une instance de FormResult
        $form_result = new FormResult();

        // on déclare nos variables de $post_data
        $annonce_id = intval($post_data['annonce_id']);
        $utilisateur_id = intval($post_data['utilisateur_id']);
        $date_debut = strtotime($post_data['date_debut']);
        $date_fin = strtotime($post_data['date_fin']);

        // on reconstruit un tableau de données
        $data = [
            'annonce_id' => $annonce_id,
            'utilisateur_id' => $utilisateur_id,
            'date_debut' => $date_debut,
            'date_fin' => $date_fin,
        ];

        // Vérifiez que la date de début est inférieure à la date de fin
        if ($date_debut > $date_fin) {
            $form_result->addError(new FormError('La date de début ne peut pas être supérieure à la date de fin'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('annonce/reserver/' . $annonce_id);
            return;
        }

        // on vérifie que les champs sont remplis
        if (
            empty($post_data['date_debut']) ||
            empty($post_data['date_fin'])
        ) {
            $form_result->addError(new FormError('Tous les champs sont obligatoires'));
            Session::set(Session::FORM_RESULT, $form_result);
            self::redirect('/annonce/reserver/' . $annonce_id);
        } else {
            // Construction du tableau de données pour Reservation
            $reservation = AppRepoManager::getRm()->getReservationRepo()->insertReservation($data);

            if (!$reservation) {
                $form_result->addError(new FormError('La réservation n\'est pas possible.'));
                Session::set(Session::FORM_RESULT, $form_result);
                self::redirect('/annonce/reserver/' . $annonce_id);
            } else {
                Session::remove(Session::FORM_RESULT);
                // puis on redirige
                self::redirect('/');
            }
        }
    }

    public function mesResa($id)
    {
        // on reconstruit notre tableau de données
        $view_data = [
            'title_tag' => 'Mes réservations',
            'h1_tag' => 'Mes réservations',
            'reservation' => AppRepoManager::getRm()->getReservationRepo()->findAllMyResaByUtilisateurId($id)
        ];
        $view = new View('annonce/mesresa');

        $view->render($view_data);
    }
}

