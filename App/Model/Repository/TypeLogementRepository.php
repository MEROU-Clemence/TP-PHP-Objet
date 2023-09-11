<?php

namespace App\Model\Repository;

use Core\Repository\Repository;

class TypeLogementRepository extends Repository
{
    public function getTableName(): string
    {
        return 'type_logement';
    }

    public function insertTypeLogement(array $data)
    {
        $q =  sprintf(
            'INSERT INTO `%s` (`label`)
           VALUES (:label)',
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
