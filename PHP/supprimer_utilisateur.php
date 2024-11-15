<?php
session_start(); // Démarrer la session pour vérifier l'authentification

// Vérification si l'utilisateur est authentifié et est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
    die("Accès non autorisé.");
}

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=sncf_ticketing;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier si l'ID de l'utilisateur est passé via POST et si c'est un entier
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && is_numeric($_POST['id'])) {
    $id = $_POST['id'];

    // Supprimer l'utilisateur
    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "Utilisateur supprimé avec succès ! <a href='/HTML/gestion_utilisateurs.html'>Retourner à la gestion des utilisateurs</a>";
} else {
    // Si l'ID n'est pas défini ou n'est pas un entier, on affiche une erreur
    echo "Erreur : ID utilisateur invalide.";
}

?>
