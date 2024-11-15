<?php
namespace App\Middleware;

class AdminMiddleware {
    public function __invoke($request, $handler) {
        // Logique pour vérifier le rôle de l'utilisateur
        if ($_SESSION['role'] !== 'admin') {
            return $response->withStatus(403)->withJson(['error' => 'Accès interdit']);
        }
        return $handler->handle($request);
    }
}
