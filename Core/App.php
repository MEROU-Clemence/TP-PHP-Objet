<?php

namespace Core;

use MiladRahimi\PhpRouter\Router;
use App\Controller\AuthController;
use App\Controller\AdminController;
use Core\Database\DatabaseConfigInterface;
use MiladRahimi\PhpRouter\Exceptions\RouteNotFoundException;
use MiladRahimi\PhpRouter\Exceptions\InvalidCallableException;

class App implements DatabaseConfigInterface
{
    // on va déclarer des constantes pour le connexion à la base de données
    private const DB_HOST = 'database';
    private const DB_NAME = 'airbnb_tp';
    private const DB_USER = 'admin';
    private const DB_PASS = 'admin';

    // on crée une propriété qui va contenir l'instance de notre classe
    private static ?self $instance = null;

    // propriété qui contient l'instance de Router (MiladRahimi)
    private Router $router;

    // création d'une méthode qui sera appelée au démarrage de l'appli dans index.php
    public static function getApp(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // méthode qui instancie Router
    public function getRouter(): Router
    {
        return $this->router;
    }

    private function __construct()
    {
        // Router::create = méthode statique de la classe Router qui permet de créer une instance de Router
        $this->router = Router::create();
    }
    // une fois le Router instancié, on aura 3 méthodes à définir
    // *** 1) méthode start (activation du router)
    public function start(): void
    {
        // on démarre la session
        session_start();
        // on enregistre les routes
        $this->registerRoutes();
        // on démarre le Router
        $this->startRouter();
    }

    // *** 2) méthode registerRoutes (enregistrement des routes)
    private function registerRoutes(): void
    {
        // on crée la route pour la page d'accueil
        // $this->router->get('/', function () {
        //     echo 'Utiliser le controller pour envoyer la vue';
        // });

        // Déclaration des patterns pour tester les valeurs des arguments
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d*-)?[a-z]+(-[a-z-\d]+)*');

        // on crée la route pour la page d'accueil avec le controlleur
        // route pour la vue connexion
        $this->router->get('/connexion', [AuthController::class, 'login']);
        // route pour envoyer le formulaire de connexion
        $this->router->post('/login', [AuthController::class, 'loginPost']);
        // route pour la déconnexion
        $this->router->get('/logout', [AuthController::class, 'logout']);
        // route pour la page admin
        $this->router->get('/admin/utilisateur', [AdminController::class, 'index']);
        $this->router->get('/admin/update/{id}', [AdminController::class, 'update']);
        $this->router->get('/admin/delete/{id}', [AdminController::class, 'deleteUtilisateur']);
        $this->router->get('/admin/addUtilisateur', [AdminController::class, 'addUtilisateur']);
        $this->router->post('/update', [AdminController::class, 'updateUtilisateur']);
    }

    // *** 3) méthode startRouter (démarrage du Router)
    private function startRouter(): void
    {
        try {
            $this->router->dispatch();
        } catch (RouteNotFoundException $e) {
            echo $e->getMessage();
        } catch (InvalidCallableException $e) {
            echo $e->getMessage();
        }
    }


    // on doit OBLIGATOIREMENT déclarer les 4 méthodes issues de l'interface
    public function getHost(): string
    {
        return self::DB_HOST;
    }

    public function getName(): string
    {
        return self::DB_NAME;
    }

    public function getUser(): string
    {
        return self::DB_USER;
    }

    public function getPass(): string
    {
        return self::DB_PASS;
    }
}
