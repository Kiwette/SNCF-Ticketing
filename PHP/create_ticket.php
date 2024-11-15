<?php
require 'db_connect.php';

$titre = $_POST['titre'];
$description = $_POST['description'];
$cree_par = $_POST['cree_par'];
$date_crea = date('Y-m-d H:i:s');
$statut = $_POST['statut'];
$priorite = $_POST['priorite'];
$categorie = $_POST['categorie'];

$sql = "INSERT INTO table_ticket (titre, description, crée_par, date_crea, statut, priorité, categorie) 
        VALUES (:titre, :description, :cree_par, :date_crea, :statut, :priorite, :categorie)";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':titre', $titre);
$stmt->bindParam(':description', $description);
$stmt->bindParam(':cree_par', $cree_par, PDO::PARAM_INT);
$stmt->bindParam(':date_crea', $date_crea);
$stmt->bindParam(':statut', $statut);
$stmt->bindParam(':priorite', $priorite);
$stmt->bindParam(':categorie', $categorie);
$stmt->execute();
?>
