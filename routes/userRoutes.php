<?php
require_once 'controllers/UserController.php';
require_once 'middleware/AuthMiddleware.php';

// Exécuter le middleware pour vérifier l'authentification
if (!AuthMiddleware::check()) {
    die("Accès interdit : Vous devez être connecté.");
}

// Voir le profil utilisateur
if ($_SERVER['REQUEST_URI'] == '/user/profile' && $_SERVER['REQUEST_METHOD'] == 'GET') {
    $controller = new UserController();
    $controller->viewProfile();
}

// Mise à jour du profil utilisateur
if ($_SERVER['REQUEST_URI'] == '/user/profile/update' && $_SERVER['REQUEST_METHOD'] == 'POST') {
    $controller = new UserController();
    $controller->updateProfile();
}
?>
