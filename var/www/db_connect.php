<?php
// db_connect.php

$host = 'db'; // Serveur MySQL
$dbname = 'sncf_ticketing'; // Nom de la base de données
$username = 'user'; // Nom d'utilisateur MySQL
$password = 'password'; // Mot de passe (par défaut vide pour root sur XAMPP)
$charset = 'utf8mb4';

// DSN (Data Source Name) pour la connexion à MySQL
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur : " . $e->getMessage());
}
?>
