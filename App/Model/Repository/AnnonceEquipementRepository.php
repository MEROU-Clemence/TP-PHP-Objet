<?php

namespace App\Model\Repository;


use App\Model\Equipement;
use Core\Repository\Repository;
use App\Model\AnnonceEquipement;
use Core\Repository\AppRepoManager;

class AnnonceEquipementRepository extends Repository
{
    public function getTableName(): string
    {
        return 'annonce_equipement';
    }

    public function getAllEquipementsByAnnonce(int $id)
    {
        // on déclare un tableau vide
        $arr_result = [];
        // on crée la requête
        $q = sprintf(
            'SELECT %3$s.label, %3$s.id
            FROM %1$s
            INNER JOIN %2$s
            ON %1$s.annonce_id = %2$s.id
            INNER JOIN %3$s
            ON %1$s.equipement_id = %3$s.id
            WHERE %2$s.id = :annonce_id',
            $this->getTableName(),
            AppRepoManager::getRm()->getAnnonceRepo()->getTableName(),
            AppRepoManager::getRm()->getEquipementRepo()->getTableName()
        );
        // on exécute la requête
        $stmt = $this->pdo->prepare($q);
        $stmt->execute(['annonce_id' => $id]);
        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return $arr_result;
        // on boucle sur les données de la requête
        while ($row_data = $stmt->fetch()) {
            // on stock dans $arr_result un nouvel objet de la classe $class_name
            $arr_result[] = new Equipement($row_data);
        }
        // on retourne le tableau
        return $arr_result;
    }

    public function insertEquipement(array $data, int $annonce_id)
    {
        foreach ($data as $equipement_id) {
            // Pour chaque équipement sélectionné, insérez une nouvelle ligne dans la table de liaison
            $q = sprintf(
                'INSERT INTO `%s` (`annonce_id`, `equipement_id`) VALUES (:annonce_id, :equipement_id)',
                $this->getTableName()
            );
            $stmt = $this->pdo->prepare($q);
            if ($stmt) {
                $stmt->execute(['annonce_id' => $annonce_id, 'equipement_id' => $equipement_id]);
            } else {
                // Gérez l'erreur de préparation de requête ici
                echo 'Vos équipements ne se sont pas inserrés';
            }
        }
    }

    public function deleteByAnnonceId(int $annonce_id): void
    {
        // Vous devrez ajuster le nom de la table et le nom de la colonne d'annonce_id
        $q = sprintf(
            'DELETE FROM `%s` 
            WHERE `annonce_id` = :annonce_id',
            $this->getTableName()
        );

        $stmt = $this->pdo->prepare($q);
        $stmt->execute(['annonce_id' => $annonce_id]);
    }
}
