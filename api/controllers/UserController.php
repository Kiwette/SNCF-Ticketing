<?php
// api/controllers/UserController.php
require_once 'C:/xampp/htdocs/api/config/Database.php';


use \Firebase\JWT\JWT;

class UserController {
    private $conn; // Connexion à la base de données

    public function __construct($db) {
        $this->conn = $db; // Stocke la connexion
    }

    // Récupérer tous les utilisateurs
    public function getAllUsers() {
        $query = "SELECT user_id, nom, prenom, email, Role_id, Numero_CP, Date_creation, Statut_compte FROM table_utilisateur";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($users);
    }

    // Créer un nouvel utilisateur
    public function createUser($data) {
        $query = "INSERT INTO table_utilisateur (nom, prenom, email, Mot_de_passe, Role_id, Numero_CP, Date_creation, Statut_compte) 
                  VALUES (:nom, :prenom, :email, :Mot_de_passe, :Role_id, :Numero_CP, :Date_creation, :Statut_compte)";
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":nom", $data->nom);
        $stmt->bindParam(":prenom", $data->prenom);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":Mot_de_passe", password_hash($data->Mot_de_passe, PASSWORD_DEFAULT)); // Hachage du mot de passe
        $stmt->bindParam(":Role_id", $data->Role_id);
        $stmt->bindParam(":Numero_CP", $data->Numero_CP);
        $stmt->bindParam(":Date_creation", $data->Date_creation);
        $stmt->bindParam(":Statut_compte", $data->Statut_compte);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Utilisateur créé avec succès."]);
        } else {
            echo json_encode(["message" => "Erreur lors de la création de l'utilisateur."]);
        }
    }

    // Connecter un utilisateur et générer un token
    public function login($data) {
        $email = $data->email;
        $password = $data->Mot_de_passe;

        // Vérifier les identifiants de l'utilisateur
        $query = "SELECT * FROM table_utilisateur WHERE email = :email LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($user && password_verify($password, $user['Mot_de_passe'])) {
            // Générer un token JWT
            $token = $this->generateToken($user['user_id'], $user['email']);
            echo json_encode(["token" => $token]);
        } else {
            echo json_encode(["message" => "Identifiants invalides."]);
        }
    }

    // Générer le token JWT
    private function generateToken($userId, $email) {
        $key = "votre_clé_secrète"; // Change ceci pour une clé plus sécurisée
        $payload = [
            "user_id" => $userId,
            "email" => $email,
            "iat" => time(),
            "exp" => time() + (60 * 60) // 1 heure d'expiration
        ];
        return JWT::encode($payload, $key);
    }

    // Mettre à jour un utilisateur
    public function updateUser($id, $data) {
        $query = "UPDATE table_utilisateur SET nom = :nom, prenom = :prenom, email = :email WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":nom", $data->nom);
        $stmt->bindParam(":prenom", $data->prenom);
        $stmt->bindParam(":email", $data->email);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Utilisateur mis à jour avec succès."]);
        } else {
            echo json_encode(["message" => "Erreur lors de la mise à jour de l'utilisateur."]);
        }
    }

    // Supprimer un utilisateur
    public function deleteUser($id) {
        $query = "DELETE FROM table_utilisateur WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            echo json_encode(["message" => "Utilisateur supprimé avec succès."]);
        } else {
            echo json_encode(["message" => "Erreur lors de la suppression de l'utilisateur."]);
        }
    }
}
?>
