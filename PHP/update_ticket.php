<?php
// Connexion à la base de données
include 'includes/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification et validation des données
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
        $sql = "UPDATE tickets SET status = :status, resolution_comment = :resolution_comment WHERE id = :ticket_id";
        $stmt = $pdo->prepare($sql);
        
        // Lier les paramètres et exécuter la requête
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':resolution_comment', $resolution_comment);
        $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);

        // Exécuter la requête et vérifier si elle a réussi
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Ticket mis à jour avec succès."]);
        } else {
            echo json_encode(["success" => false, "message" => "Erreur lors de la mise à jour du ticket."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Données manquantes dans la requête."]);
    }
}

mysqli_close($conn);  // Fermer la connexion à la base de données
?>
