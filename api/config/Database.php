<?php
class Database {
    private $host = "localhost";
    private $db_name = "nom_de_ta_base_de_donnees";
    private $username = "ton_nom_d_utilisateur";
    private $password = "ton_mot_de_passe";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->exec("set names utf8");
        } catch (PDOException $exception) {
            echo "Erreur de connexion : " . $exception->getMessage();
        }

        return $this->conn;
    }
}
