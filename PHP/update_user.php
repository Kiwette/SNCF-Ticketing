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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Mettre à jour les informations de l'utilisateur
    $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $role, $id]);

    echo "Utilisateur mis à jour avec succès ! <a href='/HTML
