<?php
// Démarrer la session pour vérifier l'utilisateur connecté
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Administrateur') {
    die('Accès interdit');
}

// Connexion à la base de données
require_once '../config/database.php';

// Valider et assainir les données envoyées via POST
$data = json_decode(file_get_contents("php://input"), true);

// Vérifier si les paramètres nécessaires sont présents
if (isset($data['role']) && isset($data['userId'])) {
    $userId = (int) $data['userId']; // Assurez-vous que l'ID de l'utilisateur est un entier
    $newRole = htmlspecialchars($data['role']); // Assainir le rôle pour éviter les attaques XSS

    // Validation des rôles autorisés
    $validRoles = ['Utilisateur', 'Administrateur']; // Liste des rôles valides
    if (!in_array($newRole, $validRoles)) {
        echo json_encode(['message' => 'Rôle invalide']);
        exit;
    }

    // Préparer la requête SQL pour la mise à jour du rôle
    try {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET role = ? WHERE id = ?");
        $stmt->execute([$newRole, $userId]);

        // Vérifier si la mise à jour a été effectuée avec succès
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Rôle mis à jour avec succès']);
        } else {
            echo json_encode(['message' => 'Aucun utilisateur trouvé avec cet ID']);
        }
    } catch (PDOException $e) {
        // Gestion des erreurs de la base de données
        echo json_encode(['message' => 'Erreur lors de la mise à jour du rôle : ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['message' => 'Paramètres manquants']);
}
?>
