<?php
// Connexion à la base de données
include 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];
    $resolution_comment = $_POST['resolution_comment'];

    $query = "UPDATE tickets SET status = '$status', resolution_comment = '$resolution_comment' WHERE id = $ticket_id";

    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Ticket mis à jour avec succès."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour du ticket."]);
    }
}

mysqli_close($conn);
?>
