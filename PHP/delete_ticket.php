<?php
// Connexion à la base de données
include 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'];

    $query = "DELETE FROM tickets WHERE id = $ticket_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Ticket supprimé avec succès."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la suppression du ticket."]);
    }
}

mysqli_close($conn);
?>
