<?php

namespace App\Model\Repository;

use App\Model\Adresse;
use App\Model\Annonce;
use App\Model\Utilisateur;
use App\Model\TypeLogement;
use Core\Repository\Repository;
use Core\Repository\AppRepoManager;

class AnnonceRepository extends Repository
{
    public function getTableName(): string
    {
        return 'annonce';
    }

    public function findAll(): array
    {
        return $this->readAll(Annonce::class);
    }

    public function findById(int $id)
    {
        return $this->readById(Annonce::class, $id);
    }

    public function findMyCompleteAnnonces(): array
    // je veux obtenir un tableau avec toutes les infos de annonce et tout utilisateur et tout typelogement
    {
        // on déclare un tableau vide
        $arr_result = [];

        // on crée la requête
        $q = sprintf(
            'SELECT `%1$s`.*, `%2$s`.rue, `%2$s`.code_postal, `%2$s`.ville, `%2$s`.pays,`%3$s`.email, `%4$s`.label AS type_logement_label, `%5$s`.image_path
            FROM `%1$s`
            INNER JOIN `%2$s`
            ON `%1$s`.adresse_id = `%2$s`.id
            INNER JOIN `%3$s`
            ON `%1$s`.utilisateur_id = `%3$s`.id
            INNER JOIN `%4$s`
            ON `%1$s`.type_logement_id = `%4$s`.id
            INNER JOIN `%5$s`
            ON `%1$s`.id = `%5$s`.annonce_id',
            // donner la valeur de %1$s qui correspond à la table toys
            $this->getTableName(),
            // donner la valeur de %2$s qui correspond à la table brands
            // on le récupère à travers notre AppRepoManager
            AppRepoManager::getRm()->getAdresseRepo()->getTableName(),
            AppRepoManager::getRm()->getUtilisateurRepo()->getTableName(),
            AppRepoManager::getRm()->getTypeLogementRepo()->getTableName(),
            AppRepoManager::getRm()->getPhotoRepo()->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->query($q);

        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return $arr_result;
        // on boucle sur les données de la requête
        while ($row_data = $stmt->fetch()) {
            // on stock dans $arr_result un nouvel objet de la classe $class_name
            $annonce = new Annonce($row_data);
            // on reconstitue un tableau pour hydrater Adresse
            $adresse_data = [
                'id' => $annonce->adresse_id,
                'rue' => $row_data['rue'],
                'code_postal' => $row_data['code_postal'],
                'ville' => $row_data['ville'],
                'pays' => $row_data['pays']
            ];

            // on reconstitue un tableau pour hydrater utilisateur
            $utilisateur_data = [
                'id' => $annonce->utilisateur_id,
                'email' => $row_data['email']
            ];

            // on reconstitue un tableau pour hydrater Adresse
            $type_logement_data = [
                'id' => $annonce->type_logement_id,
                'label' => $row_data['type_logement_label']
            ];

            $photo_data = AppRepoManager::getRm()->getPhotoRepo()->getAllImagesByAnnonce($annonce->id);

            // on crée un objet Adresse qu'on hydrate
            $adresse = new Adresse($adresse_data);

            // on crée un objet Adresse qu'on hydrate
            $utilisateur = new Utilisateur($utilisateur_data);

            // on crée un objet Adresse qu'on hydrate
            $typelogement = new TypeLogement($type_logement_data);



            // on ajoute les objets adresse, utilisateur et typelogement à annonce 
            $annonce->adresse = $adresse;
            $annonce->utilisateur = $utilisateur;
            $annonce->typelogement = $typelogement;
            $annonce->images = $photo_data;

            $arr_result[] = $annonce;
        }
        // on retourne le tableau
        return $arr_result;
    }

    public function findMyAnnonceById($id): ?Annonce
    {
        // on déclare un tableau vide
        $arr_result = [];

        // on crée la requête
        $q = sprintf(
            'SELECT `%1$s`.*, `%2$s`.rue, `%2$s`.code_postal, `%2$s`.ville, `%2$s`.pays,`%3$s`.email, `%4$s`.label AS type_logement_label, `%5$s`.image_path
             FROM `%1$s`
             INNER JOIN `%2$s`
             ON `%1$s`.adresse_id = `%2$s`.id
             INNER JOIN `%3$s`
             ON `%1$s`.utilisateur_id = `%3$s`.id
             INNER JOIN `%4$s`
             ON `%1$s`.type_logement_id = `%4$s`.id
             INNER JOIN `%5$s`
             ON `%1$s`.id = `%5$s`.annonce_id
             
             WHERE `%1$s`.id = :id',
            // donner la valeur de %1$s qui correspond à la table toys
            $this->getTableName(),
            // donner la valeur de %2$s qui correspond à la table brands
            // on le récupère à travers notre AppRepoManager
            AppRepoManager::getRm()->getAdresseRepo()->getTableName(),
            AppRepoManager::getRm()->getUtilisateurRepo()->getTableName(),
            AppRepoManager::getRm()->getTypeLogementRepo()->getTableName(),
            AppRepoManager::getRm()->getPhotoRepo()->getTableName(),
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($q);

        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return null;
        // on boucle sur les données de la requête
        $stmt->execute([
            'id' => $id
        ]);
        $row_data = $stmt->fetch();
        // on stock dans $arr_result un nouvel objet de la classe $class_name
        $annonce = new Annonce($row_data);
        // on reconstitue un tableau pour hydrater Adresse
        $adresse_data = [
            'id' => $annonce->adresse_id,
            'rue' => $row_data['rue'],
            'code_postal' => $row_data['code_postal'],
            'ville' => $row_data['ville'],
            'pays' => $row_data['pays']
        ];

        // on reconstitue un tableau pour hydrater utilisateur
        $utilisateur_data = [
            'id' => $annonce->utilisateur_id,
            'email' => $row_data['email']
        ];

        // on reconstitue un tableau pour hydrater Adresse
        $type_logement_data = [
            'id' => $annonce->type_logement_id,
            'label' => $row_data['type_logement_label']
        ];

        // on crée un objet Adresse qu'on hydrate
        $adresse = new Adresse($adresse_data);

        // on crée un objet Adresse qu'on hydrate
        $utilisateur = new Utilisateur($utilisateur_data);

        // on crée un objet Adresse qu'on hydrate
        $typelogement = new TypeLogement($type_logement_data);

        // Photos hydratation
        $photo_data = AppRepoManager::getRm()->getPhotoRepo()->getAllImagesByAnnonce($annonce->id);

        $equipement_data = AppRepoManager::getRm()->getAnnonceEquipementRepo()->getAllEquipementsByAnnonce($annonce->id);

        // on ajoute les objets adresse, utilisateur, typelogement, images, equipement à annonce 
        $annonce->adresse = $adresse;
        $annonce->utilisateur = $utilisateur;
        $annonce->typelogement = $typelogement;
        $annonce->images = $photo_data;
        $annonce->equipements = $equipement_data;

        return $annonce;
    }

    public function insertAnnonce(array $data)
    {
        $q =  sprintf(
            'INSERT INTO `%s` (`titre`, `adresse_id`, `utilisateur_id`, `prix`, `type_logement_id`, `taille`, `nb_pieces`, `description`, `nb_couchages`)
           VALUES (:titre, :adresse_id, :utilisateur_id, :prix, :type_logement_id, :taille, :nb_pieces, :description, :nb_couchages)',
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($q);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return false;
        // on exécute la requête
        $stmt->execute($data);

        // on récupère l'id qui vient d'être inseré.
        return $this->pdo->lastInsertId();
    }
}
