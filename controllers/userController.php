<?php

namespace App\Controllers;

use Firebase\JWT\JWT;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController {

    private $secretKey;

    public function __construct() {
        // Récupérer la clé secrète depuis les variables d'environnement
        $this->secretKey = getenv('SECRET_KEY') ?: 'default_secret_key'; // Utilisez une clé par défaut en cas d'absence
    }

    // Inscription d'un utilisateur
    public function register(Request $request, Response $response) {
        // Récupérer les données envoyées dans la requête
        $data = $request->getParsedBody();
        $username = $data['username'];
        $email = $data['email'];
        $password = $data['password'];

        // Validation des entrées
        if (empty($username) || empty($email) || empty($password)) {
            return $response->withJson(['error' => 'Tous les champs sont obligatoires'], 400);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $response->withJson(['error' => 'Email invalide'], 400);
        }

        if (strlen($password) < 6) {
            return $response->withJson(['error' => 'Le mot de passe doit contenir au moins 6 caractères'], 400);
        }

        // Hash du mot de passe
        $passwordHash = password_hash($password, PASSWORD_BCRYPT);

        // Vérifier si l'utilisateur existe déjà
        $existingUser = $this->findByUsername($username);
        if ($existingUser) {
            return $response->withJson(['error' => 'Utilisateur déjà existant'], 400);
        }

        // Créer un nouvel utilisateur dans la table "table_utilisateur"
        if ($this->createUser($username, $email, $passwordHash)) {
            return $response->withJson(['message' => 'Utilisateur créé avec succès'], 201);
        } else {
            return $response->withJson(['error' => 'Erreur lors de la création de l\'utilisateur'], 500);
        }
    }

    // Connexion d'un utilisateur
    public function login(Request $request, Response $response) {
        // Récupérer les données envoyées dans la requête
        $data = $request->getParsedBody();
        $username = $data['username'];
        $password = $data['password'];

        // Vérifier si l'utilisateur existe dans la table "table_utilisateur"
        $user = $this->findByUsername($username);
        if (!$user) {
            return $response->withJson(['error' => 'Utilisateur non trouvé'], 404);
        }

        // Vérifier le mot de passe
        if (!password_verify($password, $user['password'])) {
            return $response->withJson(['error' => 'Mot de passe incorrect'], 401);
        }

        // Générer un token JWT
        $issuedAt = time();
        $expirationTime = $issuedAt + 3600;  // expire dans 1 heure
        $payload = [
            'iat' => $issuedAt,
            'exp' => $expirationTime,
            'userId' => $user['id'],
            'role' => $user['role']
        ];

        $jwt = JWT::encode($payload, $this->secretKey);

        return $response->withJson(['message' => 'Connexion réussie', 'token' => $jwt], 200);
    }

    // Fonction pour trouver un utilisateur par son nom d'utilisateur
    private function findByUsername($username) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM table_utilisateur WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch();
    }

    // Fonction pour créer un utilisateur
    private function createUser($username, $email, $password) {
        global $pdo;
        try {
            $stmt = $pdo->prepare("INSERT INTO table_utilisateur (username, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$username, $email, $password, 'user']);
        } catch (\PDOException $e) {
            return false; // En cas d'échec, retourner false
        }
        return true; // Succès
    }
}
?>
