<?php
require_once 'Database.php';

class Utilisateur {
    private $conn;
    private $table_name = "table_utilisateur";

    public $id;
    public $nom;
    public $prenom;
    public $email;
    public $mot_de_passe;

    public function __construct(){
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    // Créer un nouvel utilisateur
    public function create(){
        $query = "INSERT INTO " . $this->table_name . " 
                  SET nom = :nom, prenom = :prenom, email = :email, 
                      mot_de_passe = :mot_de_passe";

        $stmt = $this->conn->prepare($query);
        $this->nom = htmlspecialchars(strip_tags($this->nom));
        $this->prenom = htmlspecialchars(strip_tags($this->prenom));
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->mot_de_passe = password_hash($this->mot_de_passe, PASSWORD_BCRYPT);

        $stmt->bindParam(":nom", $this->nom);
        $stmt->bindParam(":prenom", $this->prenom);
        $stmt->bindParam(":email", $this->email);
        $stmt->bindParam(":mot_de_passe", $this->mot_de_passe);

        return $stmt->execute();
    }

    // Lire un utilisateur par ID
    public function readOne(){
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ? LIMIT 0,1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->id);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if($row){
            $this->nom = $row['nom'];
            $this->prenom = $row['prenom'];
            $this->email = $row['email'];
            return true;
        }
        return false;
    }
}
?>
