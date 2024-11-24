<?php
// Démarrer la session
session_start();

// Inclure la connexion à la base de données
require_once __DIR__ . '/app/config/Database.php';


// Vérifier si l'utilisateur est authentifié
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Utilisateur non authentifié']);
    exit;
}

// Supprimer un utilisateur
if (isset($_POST['action']) && $_POST['action'] == 'delete' && isset($_POST['user_id'])) {
    $user_id = $_POST['user_id'];

    // Requête pour supprimer l'utilisateur
    $query = "DELETE FROM utilisateurs WHERE user_id = :user_id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Utilisateur supprimé avec succès']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Erreur lors de la suppression']);
    }
    exit;
}


?>
