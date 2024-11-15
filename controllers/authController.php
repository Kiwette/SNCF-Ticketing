<?php

// Inclure la connexion à la base de données et d'autres nécessaires
require_once __DIR__ . '/config/db_connect.php';
require_once __DIR__ . '/../models/User.php';
use \Firebase\JWT\JWT;

class AuthController {
    // Inscription d'un utilisateur
    public function register($request, $response, $args) {
        // Récupérer les données du formulaire d'inscription
        $data = $request->getParsedBody();
        
        // Vérifier si les informations nécessaires sont présentes
        if (!isset($data['username'], $data['password'])) {
            return $response->withStatus(400)->write('Données manquantes');
        }

        // Hasher le mot de passe
        $hashedPassword = password_hash($data['password'], PASSWORD_BCRYPT);

        // Créer l'utilisateur dans la base de données
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        
        if ($stmt->execute([$data['username'], $hashedPassword])) {
            return $response->withStatus(201)->write('Utilisateur créé');
        } else {
            return $response->withStatus(500)->write('Erreur serveur');
        }
    }

    // Connexion d'un utilisateur
    public function login($request, $response, $args) {
        // Récupérer les données de connexion
        $data = $request->getParsedBody();
        
        if (!isset($data['username'], $data['password'])) {
            return $response->withStatus(400)->write('Données manquantes');
        }

        // Rechercher l'utilisateur dans la base de données
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$data['username']]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et le mot de passe est correct
        if ($user && password_verify($data['password'], $user['password'])) {
            // Créer un jeton JWT
            $key = "votre_cle_secrète";
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600;  // 1 heure
            $payload = array(
                "iss" => "localhost",
                "iat" => $issuedAt,
                "exp" => $expirationTime,
                "userId" => $user['id'],
                "username" => $user['username']
            );

            $jwt = JWT::encode($payload, $key);

            // Retourner le jeton JWT
            return $response->withJson(['token' => $jwt], 200);
        } else {
            return $response->withStatus(401)->write('Nom d\'utilisateur ou mot de passe incorrect');
        }
    }

    // Déconnexion d'un utilisateur
    public function logout($request, $response, $args) {
        // Vous pouvez gérer la déconnexion via des sessions ou autres méthodes
        // Si vous utilisez JWT, il suffit de supprimer le jeton du côté client
        return $response->withStatus(200)->write('Utilisateur déconnecté');
    }
}
