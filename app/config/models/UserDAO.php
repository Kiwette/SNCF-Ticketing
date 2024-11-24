<?php

class UserDAO {
    private $pdo;

    // Constructeur pour initialiser l'objet PDO
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    // Ajouter un utilisateur
    public function addUser($nom, $prenom, $email, $password, $role_id) {
        $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id, statut_compte, date_creation) 
                VALUES (:nom, :prenom, :email, :password, :role_id, 'Actif', NOW())";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':prenom', $prenom);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', password_hash($password, PASSWORD_DEFAULT));
        $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Supprimer un utilisateur
    public function deleteUser($user_id) {
        $sql = "DELETE FROM utilisateurs WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Mettre à jour le rôle d'un utilisateur
    public function updateUserRole($user_id, $new_role) {
        $sql = "UPDATE utilisateurs SET role_id = :new_role WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':new_role', $new_role, PDO::PARAM_INT);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $sql = "SELECT * FROM utilisateurs";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Récupérer un utilisateur par son ID
    public function getUserById($user_id) {
        $sql = "SELECT * FROM utilisateurs WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>
