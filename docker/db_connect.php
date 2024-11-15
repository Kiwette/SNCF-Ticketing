<?php
// db_connect.php

$host = 'localhost'; // Serveur MySQL
$dbname = 'sncf_ticketing'; // Nom de la base de données
$username = 'root'; // Nom d'utilisateur MySQL
$password = ''; // Mot de passe (par défaut vide pour root sur XAMPP)
$charset = 'utf8mb4';

// DSN (Data Source Name) pour la connexion à MySQL
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    // Création de la connexion PDO
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // En cas d'échec, afficher l'erreur
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
?>
