<?php

namespace App\Model;

use Core\Model\Model;
use App\Model\Annonce;

class Photo extends Model
{
    public string $image_path;
    public int $annonce_id;

    public ?Annonce $annonce = null;
}
