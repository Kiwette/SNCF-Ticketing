<?php

// Inclure les contrôleurs nécessaires
require_once '../controllers/commentController.php';

// Définir le type de contenu pour les réponses JSON
header('Content-Type: application/json');

// Gérer les routes
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Route pour récupérer tous les commentaires
if ($requestUri == '/api/comments' && $requestMethod == 'GET') {
    getComments(); // Appeler la fonction pour récupérer tous les commentaires
}
// Route pour créer un commentaire
elseif ($requestUri == '/api/comments' && $requestMethod == 'POST') {
    createComment(); // Appeler la fonction pour créer un commentaire
}
// Route pour mettre à jour un commentaire (PUT)
elseif (preg_match('/^\/api\/comments\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'PUT') {
    $id = $matches[1];
    updateComment($id); // Appeler la fonction pour mettre à jour un commentaire
}
// Route pour supprimer un commentaire (DELETE)
elseif (preg_match('/^\/api\/comments\/(\d+)$/', $requestUri, $matches) && $requestMethod == 'DELETE') {
    $id = $matches[1];
    deleteComment($id); // Appeler la fonction pour supprimer un commentaire
}
// Si la route n'est pas définie, renvoyer une erreur 404
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Route non trouvée"]);
}

?>
