<?php
// Fichier pour se connecter à la base de données

// Paramètres de connexion à la base de données
$host = 'localhost'; // L'adresse de votre serveur MySQL
$db_name = 'sncf_ticketing'; // Le nom de votre base de données
$username = 'root'; // Votre utilisateur MySQL
$password = ''; // Votre mot de passe MySQL

// Créer une instance de PDO pour la connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les erreurs PDO
} catch (PDOException $e) {
    // Afficher un message d'erreur si la connexion échoue
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
