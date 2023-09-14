<?php

namespace Core;

use MiladRahimi\PhpRouter\Router;
use App\Controller\AuthController;
use App\Controller\AnnonceController;
use App\Controller\InscriptionController;
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

        // Déclaration des patterns pour tester les valeurs des arguments
        $this->router->pattern('id', '[0-9]\d*');
        $this->router->pattern('slug', '(\d*-)?[a-z]+(-[a-z-\d]+)*');

        // on crée les routes avec le controlleur
        // on crée la route pour la page d'accueil
        $this->router->get('/', [AnnonceController::class, 'index']);
        // route pour le detail de mes annonces.
        $this->router->get('/annonce/{id}', [AnnonceController::class, 'detail']);


        // route pour la vue connexion
        $this->router->get('/connexion', [AuthController::class, 'login']);
        // route pour envoyer le formulaire de connexion
        $this->router->post('/login', [AuthController::class, 'loginPost']);
        // route pour la déconnexion
        $this->router->get('/logout', [AuthController::class, 'logout']);

        // route pour aller vers l'inscription
        $this->router->get('/inscription', [InscriptionController::class, 'createInscription']);
        // route pour envoyer le formulaire d'inscription
        $this->router->post('/inscriptionPost', [InscriptionController::class, 'inscriptionPost']);

        // route pour aller vers l'ajout d'une annonce
        $this->router->get('/addannonce', [AuthController::class, 'addAnnonce']);
        // route pour envoyer le formulaire de ma nouvelle annonce
        $this->router->post('/annoncePost', [AuthController::class, 'annoncePost']);

        // route pour la modification d'une annonce
        $this->router->get('/updateannonce/{id}', [AnnonceController::class, 'editAnnonce']);
        // on poste la modification
        $this->router->post('/updateAnnonce', [AnnonceController::class, 'updateAnnonce']);

        // route pour aller vers une réservation
        $this->router->get('/reserver/{id}', [AnnonceController::class, 'reserverAnnonce']);
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
