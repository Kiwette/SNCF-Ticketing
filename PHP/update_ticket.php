<?php
// Connexion à la base de données
require_once 'config/db_connect.php'; // Assurez-vous que le chemin est correct

session_start();

// Vérification du rôle de l'utilisateur (administrateur)
if ($_SESSION['role'] !== 'Administrateur') {
    echo json_encode(["success" => false, "message" => "Accès refusé."]);
    exit;
}

// Vérification et validation des données
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['ticket_id'], $_POST['status'], $_POST['resolution_comment'])) {
        $ticket_id = $_POST['ticket_id'];
        $status = $_POST['status'];
        $resolution_comment = $_POST['resolution_comment'];

        // Valider que le ticket_id est un entier
        if (!is_numeric($ticket_id)) {
            echo json_encode(["success" => false, "message" => "ID de ticket invalide."]);
            exit;
        }

        // Assainir les autres données pour éviter des injections XSS
        $status = htmlspecialchars($status);
        $resolution_comment = htmlspecialchars($resolution_comment);

        // Utilisation de requêtes préparées pour éviter les injections SQL
        $sql = "UPDATE tickets SET status = ?, resolution_comment = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $sql);

        // Vérifier si la préparation de la requête a réussi
        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Erreur de préparation de la requête."]);
            exit;
        }

        // Lier les paramètres et exécuter la requête
        mysqli_stmt_bind_param($stmt, 'ssi', $status, $resolution_comment, $ticket_id);

        // Exécuter la requête et vérifier si elle a réussi
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(["success" => true, "message" => "Ticket mis à jour avec succès."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour du ticket."]);
        }

        // Fermer la requête préparée
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["success" => false, "message" => "Données manquantes dans la requête."]);
    }
}

// Fermer la connexion à la base de données
mysqli_close($conn);
?>
