<?php

namespace App\Model\Repository;


use App\Model\Equipement;
use Core\Repository\Repository;

class EquipementRepository extends Repository
{
    public function getTableName(): string
    {
        return 'equipement';
    }

    public function findAll(): array
    {
        return $this->readAll(Equipement::class);
    }

    public function insertEquipement(array $data, int $annonce_id)
    {
        // TODO: foreach sur $data (dedans mettre une requete d'insertion avec passage de boucle sur mes equipements )
        // Vérifiez si le tableau 'equipement' existe dans les données
        if (isset($data['equipement']) && is_array($data['equipement'])) {
            foreach ($data['equipement'] as $equipement_id) {
                // Pour chaque équipement sélectionné, insérez une nouvelle ligne dans la table de liaison
                $q = 'INSERT INTO `annonce_equipement` (`annonce_id`, `equipement_id`) VALUES (:annonce_id, :equipement_id)';
                $stmt = $this->pdo->prepare($q);
                if ($stmt) {
                    $stmt->bindValue(':annonce_id', $annonce_id, PDO::PARAM_INT);
                    $stmt->bindValue(':equipement_id', $equipement_id, PDO::PARAM_INT);
                    $stmt->execute();
                } else {
                    // Gérez l'erreur de préparation de requête ici
                    echo 'Vos équipements ne se sont pas inserrés';
                }
            }
        }
        var_dump($data);
        die();
             
    }
}
