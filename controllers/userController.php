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

// Fonction pour récupérer un utilisateur par ID
function getUserById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE id = ?");
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        echo json_encode($user);
    } else {
        echo json_encode(["message" => "Utilisateur non trouvé"]);
    }
}

// Fonction pour mettre à jour le rôle de l'utilisateur
function updateUserRole($id, $newRole) {
    global $pdo;
    // On vérifie que le rôle passé est valide (par exemple : 'user', 'admin')
    $validRoles = ['user', 'admin'];

    if (in_array($newRole, $validRoles)) {
        $stmt = $pdo->prepare("UPDATE utilisateurs SET role = ? WHERE id = ?");
        $stmt->execute([$newRole, $id]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(["message" => "Rôle mis à jour avec succès"]);
        } else {
            echo json_encode(["message" => "Utilisateur non trouvé ou aucun changement"]);
        }
    } else {
        echo json_encode(["message" => "Rôle invalide"]);
    }

    
}

?>
