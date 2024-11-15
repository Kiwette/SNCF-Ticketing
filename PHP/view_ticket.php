<?php
include 'auth.php';
verifier_acces(['administrateur', 'support_technique']); // Autorisé pour administrateur et support technique

$ticket_id = $_GET['id'];
$sql = "SELECT * FROM table_ticket WHERE id_ticket = :ticket_id";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
$stmt->execute();
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Détails du Ticket</title>
</head>
<body>
    <h1>Détails du Ticket</h1>
    <p>ID : <?= htmlspecialchars($ticket['id_ticket']); ?></p>
    <p>Statut : <?= htmlspecialchars($ticket['statut']); ?></p>
</body>
</html>
