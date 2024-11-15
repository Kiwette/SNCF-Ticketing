<?php

require_once __DIR__ . '/config/db_connect.php';
use \Firebase\JWT\JWT;

class HomeController {
    // Page d'accueil pour l'utilisateur authentifié
    public function home($request, $response, $args) {
        // Vérification du token JWT
        $token = $request->getHeaderLine('Authorization');

        if (!$token) {
            return $response->withStatus(401)->write('Token manquant');
        }

        try {
            $key = "votre_cle_secrète";
            $decoded = JWT::decode($token, $key, ['HS256']);
            $userId = $decoded->userId;

            // Rechercher l'utilisateur dans la base de données
            $sql = "SELECT * FROM users WHERE id = ?";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$userId]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                return $response->withJson($user, 200);
            } else {
                return $response->withStatus(404)->write('Utilisateur non trouvé');
            }

        } catch (Exception $e) {
            return $response->withStatus(401)->write('Token invalide');
        }
    }
}
