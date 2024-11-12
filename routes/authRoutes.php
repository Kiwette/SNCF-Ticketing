<?php

// Inclure les contrôleurs nécessaires
require_once '../controllers/authController.php';

// Définir l'en-tête Content-Type pour les réponses JSON
header('Content-Type: application/json');

// Gérer les routes
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Route pour l'inscription
if ($requestUri == '/api/auth/signup' && $requestMethod == 'POST') {
    signup(); // Appeler la fonction signup() du contrôleur authController.php
}
// Route pour la connexion
elseif ($requestUri == '/api/auth/login' && $requestMethod == 'POST') {
    login(); // Appeler la fonction login() du contrôleur authController.php
}
// Route pour la déconnexion (si nécessaire)
elseif ($requestUri == '/api/auth/logout' && $requestMethod == 'POST') {
    logout(); // Appeler la fonction logout() du contrôleur authController.php
}
// Si la route n'est pas définie, on renvoie une erreur 404
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Route non trouvée"]);
}

?>
