<?php
// Inclure la connexion à la base de données
require_once 'config/db_connect.php';

class UserModel {
    // Créer un utilisateur
    public function createUser($username, $email, $password) {
        global $pdo;
        $sql = "INSERT INTO users (username, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([$username, $email, $password]);
    }

    // Récupérer un utilisateur par son nom d'utilisateur
    public function findUserByUsername($username) {
        global $pdo;
        $sql = "SELECT * FROM users WHERE username = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
