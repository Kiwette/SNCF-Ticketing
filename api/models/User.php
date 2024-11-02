<?php
// api/models/User.php
class User {
    private $conn;
    private $table = 'table_utilisateur'; 

    // Propriétés correspondant aux colonnes de la table
    public $user_id;     
    public $nom;   
    public $prenom;  
    public $email;  
    public $Mot_de_passe;  
    public $Confirm_mdp;  
    public $Role_id;  
    public $Numero_CP;  
    public $Date_creation;  
    public $Statut_compte;  

    public function __construct($db) {
        $this->conn = $db;
    }

    // Méthode pour récupérer tous les utilisateurs
    public function getUsers() {
        $query = "SELECT user_id, nom, prenom, email, Role_id, Numero_CP, Date_creation, Statut_compte FROM " . $this->table; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Méthode pour créer un utilisateur
    public function createUser() {
        $query = "INSERT INTO " . $this->table . " (nom, prenom, email, Mot_de_passe, Role_id, Numero_CP, Date_creation, Statut_compte) VALUES (:nom, :prenom, :email, :Mot_de_passe, :Role_id, :Numero_CP, :Date_creation, :Statut_compte)"; 
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":Mot_de_passe", $this->Mot_de_passe);
        $stmt->bindParam(":Role_id", $this->Role_id);
        $stmt->bindParam(":Numero_CP", $this->Numero_CP);
        $stmt->bindParam(":Date_creation", $this->Date_creation);
        $stmt->bindParam(":Statut_compte", $this->Statut_compte);

        return $stmt->execute();
    }

    // Méthode pour mettre à jour un utilisateur
    public function updateUser() {
        $query = "UPDATE " . $this->table . " SET 
            nom = :nom, 
            prenom = :prenom, 
            email = :email, 
            Mot_de_passe = :Mot_de_passe, 
            Role_id = :Role_id, 
            Numero_CP = :Numero_CP, 
            Date_creation = :Date_creation, 
            Statut_compte = :Statut_compte 
            WHERE user_id = :id";
        
        $stmt = $this->conn->prepare($query);

        // Liaison des paramètres
        $stmt->bindParam(":id", $this->user_id);
        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":Mot_de_passe", $this->Mot_de_passe);
        $stmt->bindParam(":Role_id", $this->Role_id);
        $stmt->bindParam(":Numero_CP", $this->Numero_CP);
        $stmt->bindParam(":Date_creation", $this->Date_creation);
        $stmt->bindParam(":Statut_compte", $this->Statut_compte);

        return $stmt->execute();
    }

    // Méthode pour supprimer un utilisateur
    public function deleteUser($id) {
        $query = "DELETE FROM " . $this->table . " WHERE user_id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }
}
?>
