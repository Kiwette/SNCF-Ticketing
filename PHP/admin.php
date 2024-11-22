<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et si c'est un administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    // Si l'utilisateur n'est pas un admin, rediriger vers la page d'accueil
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panneau d'Administration</title>
    <link rel="stylesheet" href="/public/CSS/admin.css">
</head>
<body>

    <h1>Panneau d'Administration</h1>

    <h2>Gestion des Tickets</h2>
    <ul>
        <li><a href="page_tickets.php">Voir les tickets</a></li>
        <li><a href="gestion_priorites.php">Gérer les priorités</a></li>
        <li><a href="gestion_categories.php">Gérer les catégories</a></li>
        <li><a href="gestion_statuts.php">Gérer les statuts</a></li>
    </ul>

    <h2>Gestion des Utilisateurs</h2>
    <ul>
        <li><a href="gestion_utilisateurs.php">Voir les utilisateurs</a></li>
        <li><a href="gestion_roles.php">Gérer les rôles</a></li>
    </ul>

</body>
</html>
