<?php

namespace Core\Repository;

use PDO;
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
}
