<?php

namespace App\Model\Repository;

use Core\Repository\Repository;

class ReservationRepository extends Repository
{
    public function getTableName(): string
    {
        return 'reservation';
    }
}
