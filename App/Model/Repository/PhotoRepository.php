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

    public function insertPhotos(array $data)
    {
        $q =  sprintf(
            'INSERT INTO `%s` (`image_path`, `annonce_id`)
           VALUES (:image_path, :annonce_id)',
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

    public function findMyPhotosByAnnonce(int $id): ?array
    {
        // Créez une requête pour récupérer toutes les photos liées à une annonce spécifique
        $q = sprintf(
            'SELECT * FROM `%s` 
            WHERE `annonce_id` = :annonce_id',
            $this->getTableName()
        );

        // Préparez la requête
        $stmt = $this->pdo->prepare($q);

        // Exécutez la requête en liant le paramètre :annonce_id
        $stmt->execute(['annonce_id' => $id]);

        // Récupérez toutes les photos liées à l'annonce
        $images = [];
        while ($row = $stmt->fetch()) {
            $images[] = new Photo($row);
        }

        return $images;
    }

}
