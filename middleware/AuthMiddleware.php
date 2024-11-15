<?php
namespace App\Middleware;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class AuthMiddleware {
    public function __invoke(Request $request, Response $response, $next) {
        // Démarrer la session si ce n'est pas déjà fait
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Vérifier si l'utilisateur est authentifié (présence d'un ID utilisateur dans la session)
        if (!isset($_SESSION['user_id'])) {
            // Si l'utilisateur n'est pas authentifié, retour d'une erreur 401
            return $response->withStatus(401)->write('Non authentifié');
        }

        // Si l'utilisateur est authentifié, continue avec la requête suivante
        return $next($request, $response);
    }
}
