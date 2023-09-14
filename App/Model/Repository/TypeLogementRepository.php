<?php

namespace App\Model\Repository;

use App\Model\TypeLogement;
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

    public function findAll(): array
    {
        return $this->readAll(TypeLogement::class);
    }

    public function update(array $data)
    {
        // on stocke d'id avant de unset
        $id = $data['id'];
        // unset: enlève un élément d'un tableau
        unset($data['id']);

        // dans un foreach il faut reconstruire une string avec clé=valeur séparée par des ,
        // on déclare un tableau vide
        $keysArray = [];
        // dans le foreach, on rempli le tableau déclaré précédemment
        foreach ($data as $key => $value) {
            $keysArray[] = $key . '=:' . $key;
        }
        $keysString = implode(', ', $keysArray);
        var_dump($keysString);

        // création de la requête
        $q = sprintf(
            'UPDATE `%1$s` SET %2$s WHERE id = %3$s',
            $this->getTableName(),
            $keysString,
            $id
        );

        // on prépare la requête
        $stmt = $this->pdo->prepare($q);
        // on vérifie que la requête est bien préparée
        if (!$stmt) return false;
        // on exécute la requête
        $stmt->execute($data);
        return true;
    }
}
