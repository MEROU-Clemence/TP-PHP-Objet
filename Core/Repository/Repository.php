<?php

namespace Core\Repository;

use PDO;
use Core\Model\Model;
use Core\Database\Database;
use Core\Database\DatabaseConfigInterface;

abstract class Repository
{
    protected PDO $pdo;

    abstract public function getTableName(): string;

    public function __construct(DatabaseConfigInterface $config)
    {
        $this->pdo = Database::getPDO($config);
    }

    protected function readAll(string $class_name): array
    {
        // on déclare un tableau vide
        $arr_result = [];
        // on crée la requête
        $q = sprintf("SELECT * FROM %s", $this->getTableName());
        // on exécute la requête
        $stmt = $this->pdo->query($q);
        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return $arr_result;
        // on boucle sur les données de la requête
        while ($row_data = $stmt->fetch()) {
            // on stock dans $arr_result un nouvel objet de la classe $class_name
            $arr_result[] = new $class_name($row_data);
        }
        // on retourne le tableau
        return $arr_result;
    }

    protected function readById(string $class_name, int $id): ?Model
    {
        // on crée la requête
        $q = sprintf("SELECT * FROM %s WHERE id=:id", $this->getTableName());
        // on exécute la requête
        $stmt = $this->pdo->prepare($q);
        // si la requête n'est pas valide, on retourne le tableau vide
        if (!$stmt) return null;

        // on exécute la requête
        $stmt->execute(['id' => $id]);
        // on récupère les résultats
        $row_data = $stmt->fetch();
        // on retourne un objet de la classe $class_name
        return !empty($row_data) ? new $class_name($row_data) : null;
    }

    protected function delete(int $id)
    {
        // on crée la requête
        $q = sprintf("DELETE FROM %s WHERE id=:id", $this->getTableName());
        // on prépare la requête
        $stmt = $this->pdo->prepare($q);
        // si la requête n'est pas vide, on retourne le tableau vide
        if (!$stmt) return false;

        // on exécute la requête
        $stmt->execute(['id' => $id]);

        return true;
    }
}
