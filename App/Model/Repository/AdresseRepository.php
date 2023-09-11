<?php

namespace App\Model\Repository;

use Core\Repository\Repository;

class AdresseRepository extends Repository
{
    public function getTableName(): string
    {
        return 'adresse';
    }

    public function insertAdresse(array $data)
    {
        $q =  sprintf(
            'INSERT INTO `%s` (`rue`, `code_postal`, `ville`, `pays`)
           VALUES (:rue, :code_postal, :ville, :pays)',
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