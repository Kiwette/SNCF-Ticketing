<?php
// Inclure la connexion à la base de données
require 'db_connect.php';

// Récupérer et valider les données
$ticket_id = $_POST['ticket_id'];
if (!filter_var($ticket_id, FILTER_VALIDATE_INT)) {
    die("ID de ticket invalide.");
}

$date_modification = date('Y-m-d H:i:s');
$action_ticket = $_POST['action_ticket'];
$ancien_statut = $_POST['ancien_statut'];
$nouveau_statut = $_POST['nouveau_statut'];
$commentaire = $_POST['commentaire'];

// Préparer la requête pour insérer l'historique
$sql = "INSERT INTO table_historique_tickets (ticket_id, date_modification, action_ticket, ancien_statut, nouveau_statut, commentaire) 
        VALUES (:ticket_id, :date_modification, :action_ticket, :ancien_statut, :nouveau_statut, :commentaire)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
$stmt->bindParam(':date_modification', $date_modification);
$stmt->bindParam(':action_ticket', $action_ticket);
$stmt->bindParam(':ancien_statut', $ancien_statut);
$stmt->bindParam(':nouveau_statut', $nouveau_statut);
$stmt->bindParam(':commentaire', $commentaire);

// Exécuter la requête et gérer les erreurs
if ($stmt->execute()) {
    echo "Historique ajouté avec succès.";
} else {
    echo "Erreur lors de l'ajout de l'historique.";
    // Tu peux aussi loguer cette erreur pour un diagnostic plus poussé
}
?>
