<?php
session_start();

// Vérifiez si l'utilisateur est connecté et s'il a le bon rôle
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, redirigez vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Vérifiez le rôle de l'utilisateur
if ($_SESSION['role'] !== 'Administrateur') {
    // Si l'utilisateur n'est pas un administrateur, redirigez vers une page d'erreur ou vers l'accueil
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

    <header>
        <h1>Panneau d'Administration</h1>
        <!-- Ajouter un bouton de déconnexion -->
        <a href="deconnexion.php">Déconnexion</a>
    </header>

    <main>
        <section>
            <h2>Gestion des Tickets</h2>
            <ul>
                <li><a href="page_tickets.php">Voir les tickets</a></li>
                <li><a href="gestion_priorites.php">Gérer les priorités</a></li>
                <li><a href="gestion_categories.php">Gérer les catégories</a></li>
                <li><a href="gestion_statuts.php">Gérer les statuts</a></li>
            </ul>
        </section>

        <section>
            <h2>Gestion des Utilisateurs</h2>
            <ul>
                <li><a href="gestion_utilisateurs.php">Voir les utilisateurs</a></li>
                <li><a href="gestion_roles.php">Gérer les rôles</a></li>
            </ul>
        </section>
    </main>

</body>
</html>
