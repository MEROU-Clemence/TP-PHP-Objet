<?php

namespace App\Controller;

use Core\View\View;
use Core\Controller\Controller;

class AnnonceController extends Controller
{
    public function index()
    {
        $view = new View('annonce/index');

        $view->render();
    }
}
