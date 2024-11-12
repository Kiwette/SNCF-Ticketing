<?php
// Connexion à la base de données
require_once '../config/database.php';

// Fonction pour récupérer tous les utilisateurs
function getUsers() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM utilisateurs");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($users);
}

getUsers();
?>
