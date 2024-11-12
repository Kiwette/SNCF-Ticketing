<?php
// Connexion à la base de données
include 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cp = $_POST['cp'];
    $role = $_POST['role'];
    $subject = $_POST['subject'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];

    $query = "INSERT INTO tickets (cp, role, subject, category, priority, description, status, created_by)
              VALUES ('$cp', '$role', '$subject', '$category', '$priority', '$description', 'En attente', 'admin')";
    
    if (mysqli_query($conn, $query)) {
        echo json_encode(["success" => true, "message" => "Ticket créé avec succès."]);
    } else {
        echo json_encode(["success" => false, "message" => "Erreur lors de la création du ticket."]);
    }
}

mysqli_close($conn);
?>
