<?php
session_start();

// Vérification du rôle d'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'administrateur') {
    header('Location: access_denied.php');
    exit();
}

// Connexion à la base de données pour afficher les statistiques (optionnel)
require 'db_connect.php';

try {
    // Récupération de quelques statistiques
    $totalUsers = $pdo->query("SELECT COUNT(*) FROM table_utilisateur")->fetchColumn();
    $openTickets = $pdo->query("SELECT COUNT(*) FROM table_ticket WHERE statut = 'ouvert'")->fetchColumn();
} catch (Exception $e) {
    echo "Erreur lors de la récupération des statistiques.";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Tableau de Bord Administrateur</title>
</head>
<body>
    <h1>Bienvenue, Administrateur</h1>

    <!-- Statistiques de base -->
    <div>
        <p>Utilisateurs enregistrés : <?= htmlspecialchars($totalUsers) ?></p>
        <p>Tickets ouverts : <?= htmlspecialchars($openTickets) ?></p>
    </div>

    <!-- Navigation du tableau de bord -->
    <nav>
        <ul>
            <li><a href="manage_users.php">Gestion des Utilisateurs</a></li>
            <li><a href="manage_tickets.php">Gestion des Tickets</a></li>
            <li><a href="view_history.php">Historique des Actions</a></li>
        </ul>
    </nav>

    <!-- Bouton de déconnexion -->
    <form action="logout.php" method="post">
        <button type="submit">Déconnexion</button>
    </form>
</body>
</html>
