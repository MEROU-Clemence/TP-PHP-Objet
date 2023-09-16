<?php

namespace App\Model\Repository;

use App\Model\Reservation;
use Core\Repository\Repository;
use Core\Repository\AppRepoManager;

class ReservationRepository extends Repository
{
    public function getTableName(): string
    {
        return 'reservation';
    }

    public function insertReservation(array $data)
    {
        $q =  sprintf(
            'INSERT INTO `%s` (`annonce_id`, `utilisateur_id`, `date_debut`, `date_fin`)
           VALUES (:annonce_id, :utilisateur_id, :date_debut, :date_fin)',
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($q);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return false;
        // on exécute la requête
        $result = $stmt->execute($data);
        
        return empty($result) ? false : true;
    }

    public function findAll(): array
    {
        return $this->readAll(Reservation::class);
    }

    public function findAllMyResaByUtilisateurId($id): array
    {
        // on déclare un tableau vide
        $arr_result = [];

        // on crée la requête
        $q = sprintf(
            'SELECT * FROM %s WHERE utilisateur_id = :id',
            // donner la valeur de %1$s qui correspond à la table toys
            $this->getTableName()
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($q);

        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return null;
        // on boucle sur les données de la requête
        $stmt->execute([
            'id' => $id
        ]);

        while ($row_data = $stmt->fetch()) {
            // on stock dans $arr_result un nouvel objet de la classe $class_name
            $reservation = new Reservation($row_data);

            $reservation->annonce = AppRepoManager::getRm()->getAnnonceRepo()->findById($row_data['annonce_id']);

            $reservation->utilisateur = AppRepoManager::getRm()->getUtilisateurRepo()->findById($row_data['utilisateur_id']);

            $reservation->annonce->images = AppRepoManager::getRm()->getPhotoRepo()->findMyPhotosByAnnonce($row_data['annonce_id']);

            $arr_result[] = $reservation;
        }

        return $arr_result;
    }
}
