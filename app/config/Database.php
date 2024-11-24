<?php

class Database {
    private static $instance = null;
    private $pdo;

    // Propriétés de la base de données
    private $host = 'localhost';
    private $dbName = 'sncf_ticketing';
    private $username = 'root';
    private $password = '';

    // Constructeur privé
    private function __construct() {
        try {
            $this->pdo = new PDO(
                "mysql:host={$this->host};dbname={$this->dbName};charset=utf8",
                $this->username,
                $this->password
            );
            // Configuration du mode d'erreur
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Erreur de connexion à la base de données : " . $e->getMessage());
        }
    }

    // Retourner l'instance unique de la classe
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();  // Création de l'objet Database
        }
        return self::$instance->pdo; // Retourne l'objet PDO
    }

    // Empêcher le clonage
    private function __clone() {}

    // Empêcher la désérialisation
    private function __wakeup() {}
}
?>
