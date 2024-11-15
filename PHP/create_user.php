<?php
require_once 'config/db_connect.php'; // Assurez-vous que le chemin est correct

$nom = $_POST['nom'];
$prenom = $_POST['prenom'];
$numero_cp = $_POST['numero_cp'];
$mail = $_POST['mail'];
$mot_de_passe = password_hash($_POST['mot_de_passe'], PASSWORD_DEFAULT);
$date_crea_comte = date('Y-m-d H:i:s');
$role = $_POST['role'];
$statut_compte = 'Actif';

$sql = "INSERT INTO table_utilisateur (nom, prénom, numero_cp, mail, mot_de_passe, date_crea_comte, role, statut_compte) 
        VALUES (:nom, :prenom, :numero_cp, :mail, :mot_de_passe, :date_crea_comte, :role, :statut_compte)";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':nom', $nom);
$stmt->bindParam(':prenom', $prenom);
$stmt->bindParam(':numero_cp', $numero_cp);
$stmt->bindParam(':mail', $mail);
$stmt->bindParam(':mot_de_passe', $mot_de_passe);
$stmt->bindParam(':date_crea_comte', $date_crea_comte);
$stmt->bindParam(':role', $role);
$stmt->bindParam(':statut_compte', $statut_compte);
$stmt->execute();
?>
