<?php
require_once 'config/db_connect.php'; 

$ticket_id = $_POST['ticket_id'];
$nom_fichier = $_FILES['fichier']['name'];
$type_fichier = pathinfo($nom_fichier, PATHINFO_EXTENSION);
$chemin_fichier = '/uploads/tickets/' . $ticket_id . '/' . $nom_fichier;
$date_ajout = date('Y-m-d H:i:s');
$ajoute_par = $_POST['ajoute_par'];

$sql = "INSERT INTO table_piece_jointe (ticket_id, nom_fichier, type_fichier, chemin_fichier, date_ajout, ajouté_par) 
        VALUES (:ticket_id, :nom_fichier, :type_fichier, :chemin_fichier, :date_ajout, :ajoute_par)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
$stmt->bindParam(':nom_fichier', $nom_fichier);
$stmt->bindParam(':type_fichier', $type_fichier);
$stmt->bindParam(':chemin_fichier', $chemin_fichier);
$stmt->bindParam(':date_ajout', $date_ajout);
$stmt->bindParam(':ajoute_par', $ajoute_par, PDO::PARAM_INT);
$stmt->execute();
?>
