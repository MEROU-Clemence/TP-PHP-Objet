<?php

namespace App\Model;

use Core\Model\Model;

class Adresse extends Model 
{
    public string $rue;
    public string $code_postal;
    public string $ville;
    public string $pays;
}