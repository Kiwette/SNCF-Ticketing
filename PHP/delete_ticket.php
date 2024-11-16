<?php
// Connexion à la base de données
require_once 'config/db_connect.php'; // Assurez-vous que le chemin est correct

session_start();

// Vérification du rôle de l'utilisateur (administrateur)
if ($_SESSION['role'] !== 'Administrateur') {
    echo json_encode(["success" => false, "message" => "Accès refusé."]);
    exit;
}

// Vérifier si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // Validation du ticket_id pour s'assurer que c'est un entier valide
    $ticket_id = filter_var($_POST['ticket_id'], FILTER_VALIDATE_INT);
    
    // Si le ticket_id est invalide
    if ($ticket_id === false) {
        echo json_encode(["success" => false, "message" => "ID de ticket invalide."]);
        exit;
    }

    // Préparer la requête SQL pour supprimer le ticket
    $query = "DELETE FROM tickets WHERE id = ?";

    // Préparer la requête avec la connexion à la base de données
    if ($stmt = mysqli_prepare($conn, $query)) {

        // Lier le paramètre $ticket_id à la requête préparée
        mysqli_stmt_bind_param($stmt, "i", $ticket_id); // "i" pour un paramètre entier

        // Exécuter la requête préparée
        if (mysqli_stmt_execute($stmt)) {
            // Si l'exécution réussie
            echo json_encode(["success" => true, "message" => "Ticket supprimé avec succès."]);
        } else {
            // Si l'exécution échoue
            echo json_encode(["success" => false, "message" => "Erreur lors de la suppression du ticket : " . mysqli_stmt_error($stmt)]);
        }

        // Fermer la requête préparée
        mysqli_stmt_close($stmt);
    } else {
        // Si la préparation de la requête échoue
        echo json_encode(["success" => false, "message" => "Erreur de préparation de la requête."]);
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
