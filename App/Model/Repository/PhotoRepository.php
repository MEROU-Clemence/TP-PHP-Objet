<?php

namespace App\Model\Repository;

use App\Model\Photo;
use Core\Repository\Repository;

class PhotoRepository extends Repository
{
    public function getTableName(): string
    {
        return 'photo';
    }

    public function getAllImagesByAnnonce(int $id)
    {
        // on déclare un tableau vide
        $arr_result = [];
        // on crée la requête
        $q = sprintf('SELECT * FROM %s WHERE annonce_id = :annonce_id', $this->getTableName());
        // on exécute la requête
        $stmt = $this->pdo->prepare($q);
        $stmt->execute(['annonce_id' => $id]);
        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return $arr_result;
        // on boucle sur les données de la requête
        while ($row_data = $stmt->fetch()) {
            // on stock dans $arr_result un nouvel objet de la classe $class_name
            $arr_result[] = new Photo($row_data);
        }
        // on retourne le tableau
        return $arr_result;
    }
}
