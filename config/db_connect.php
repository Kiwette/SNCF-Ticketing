<?php
// Paramètres de connexion à la base de données
$host = 'localhost'; 
$db_name = 'sncf_ticketing'; 
$username = 'root'; 
$password = ''; 

// Créer une instance de PDO pour la connexion à la base de données
try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Activer les erreurs PDO
} catch (PDOException $e) {
    // Afficher un message d'erreur si la connexion échoue
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
