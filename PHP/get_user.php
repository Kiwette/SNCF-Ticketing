<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=sncf_ticketing;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Requête pour récupérer tous les utilisateurs
$sql = "SELECT * FROM utilisateurs";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Retourner les utilisateurs en JSON
echo json_encode($users);
?>
