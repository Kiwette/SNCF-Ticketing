<?php

class Router {
    public function get($route, $callback) {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && $_SERVER['REQUEST_URI'] === $route) {
            $callback();
        }
    }

    public function post($route, $callback) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_SERVER['REQUEST_URI'] === $route) {
            $callback();
        }
    }

    public function notFound() {
        header("HTTP/1.1 404 Not Found");
        echo json_encode(["message" => "Page non trouvée"]);
    }

    public function getWithParams($routePattern, $callback) {
        // Utiliser une expression régulière pour capturer les paramètres
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && preg_match($routePattern, $_SERVER['REQUEST_URI'], $matches)) {
            array_shift($matches); // Retirer le premier élément qui est la chaîne entière
            $callback(...$matches); // Passer les paramètres à la fonction callback
        }
    }
}

// Créer une instance du routeur
$router = new Router();

// Route GET pour la page d'accueil
$router->get('/', function() {
    echo "Bienvenue sur la page d'accueil!";
});

// Route GET pour la page de contact
$router->get('/contact', function() {
    echo "Page de contact";
});

// Route POST pour traiter un formulaire de contact
$router->post('/contact', function() {
    // Traiter les données du formulaire
    echo "Formulaire de contact soumis!";
});

// Exemple d'une route avec un paramètre dynamique (ex : /users/{id})
$router->getWithParams('/^\/users\/(\d+)$/', function($userId) {
    echo "Affichage de l'utilisateur avec l'ID : " . $userId;
});

// Si aucune route n'est trouvée
$router->notFound();

?>
