<?php
require 'config/db_connect.php';

$ticket_id = 11; // Exemple d'ID de ticket

$sql = "SELECT utilisateur_id, action, date_action FROM table_action_ticket WHERE ticket_id = :ticket_id ORDER BY date_action DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
$stmt->execute();

$actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($actions as $action) {
    echo "Utilisateur ID : " . $action['utilisateur_id'] . "<br>";
    echo "Action : " . $action['action'] . "<br>";
    echo "Date : " . $action['date_action'] . "<br><br>";
}
?>
