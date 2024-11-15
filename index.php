<?php
require_once 'config/db_connect.php';



use Slim\Factory\AppFactory;
use App\Controllers\AuthController;
use App\Controllers\HomeController;

// Créer l'application Slim
$app = AppFactory::create();

// AuthController - Routes d'authentification
$app->post('/register', [AuthController::class, 'register']);
$app->post('/login', [AuthController::class, 'login']);
$app->post('/logout', [AuthController::class, 'logout']);



$app->get('/home', [HomeController::class, 'home'])->add(new \App\Middleware\AuthMiddleware());


// HomeController - Route de la page d'accueil
$app->get('/home', [HomeController::class, 'home'])->add(new \App\Middleware\AuthMiddleware());

// Lancer l'application
$app->run();



// Créer une application Slim
$app = \Slim\Factory\AppFactory::create();

// Définir une base de données ou un container si nécessaire (par exemple, pour la connexion à la base de données)
$container = $app->getContainer();

// Ajouter des routes depuis un fichier séparé (par exemple, authRoutes.php)
require_once __DIR__ . '/routes/authRoutes.php';

// Démarrer l'application
$app->run();
