<?php

// Inclure les contrôleurs nécessaires
require_once '../controllers/ticketController.php';

// Gérer les routes
$requestMethod = $_SERVER['REQUEST_METHOD'];
$requestUri = $_SERVER['REQUEST_URI'];

// Route pour récupérer tous les tickets
if ($requestUri == '/api/tickets' && $requestMethod == 'GET') {
    getTickets(); // Appeler la fonction pour récupérer tous les tickets
}
// Route pour créer un ticket
elseif ($requestUri == '/api/tickets' && $requestMethod == 'POST') {
    createTicket(); // Appeler la fonction pour créer un ticket
}
// Route pour récupérer un ticket par ID
elseif (preg_match('/\/api\/tickets\/(\d+)/', $requestUri, $matches) && $requestMethod == 'GET') {
    $ticketId = $matches[1]; // Capturer l'ID du ticket à partir de l'URL
    getTicketById($ticketId); // Appeler la fonction pour récupérer un ticket spécifique par ID
}
// Si la route n'est pas définie, renvoyer une erreur 404
else {
    header("HTTP/1.1 404 Not Found");
    echo json_encode(["message" => "Route non trouvée"]);
}

?>
