<?php

namespace App\Model\Repository;

use App\Model\Adresse;
use Core\Repository\Repository;

class AdresseRepository extends Repository
{
    public function getTableName(): string
    {
        return 'adresse';
    }
}