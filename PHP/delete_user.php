<?php
require_once 'config/db_connect.php'; // Assurez-vous que le chemin est correct

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=sncf_ticketing;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérifier que l'ID de l'utilisateur est passé et qu'il est valide
if (isset($_GET['id'])) {
    // Validation pour s'assurer que l'ID est un entier
    $id = filter_var($_GET['id'], FILTER_VALIDATE_INT);

    if ($id === false) {
        echo "ID de l'utilisateur invalide.";
        exit;
    }

    // Préparer et exécuter la requête pour supprimer l'utilisateur
    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    // Exécuter la requête avec l'ID validé
    if ($stmt->execute([$id])) {
        echo "Utilisateur supprimé avec succès !";
    } else {
        echo "Erreur lors de la suppression de l'utilisateur.";
    }
} else {
    echo "ID de l'utilisateur manquant.";
}
?>
