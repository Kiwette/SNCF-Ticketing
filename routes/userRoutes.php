<?php

// Inclure les contrôleurs nécessaires
require_once '../controllers/userController.php';

// Gérer les routes
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Route pour récupérer tous les utilisateurs
if ($requestUri == '/api/users' && $requestMethod == 'GET') {
    getUsers(); // Appeler la fonction pour récupérer tous les utilisateurs
}
// Route pour récupérer un utilisateur par ID
elseif (preg_match('/\/api\/users\/(\d+)/', $requestUri, $matches) && $requestMethod == 'GET') {
    getUserById($matches[1]); // Appeler la fonction pour récupérer un utilisateur spécifique par ID
}
// Route pour mettre à jour le rôle d'un utilisateur
elseif (preg_match('/\/api\/users\/(\d+)\/role/', $requestUri, $matches) && $requestMethod == 'POST') {
    $id = $matches[1];
    // On attend que le rôle soit envoyé dans le corps de la requête POST
    $input = json_decode(file_get_contents("php://input"));
    $newRole = $input->role;
    updateUserRole($id, $newRole); // Appeler la fonction pour mettre à jour le rôle
}
// Si la route n'est pas définie, on renvoie une erreur 404
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Route non trouvée"]);
}

?>
