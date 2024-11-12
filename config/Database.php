<?php
class Database {
    private $host = "localhost";
    private $db_name = "SNCF_TICKETING";
    private $username = "root";
    private $password = "0000";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            // Crée la connexion PDO à la base de données
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            // Si la connexion échoue, affiche l'erreur
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
