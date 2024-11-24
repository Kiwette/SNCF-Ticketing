<?php
// Démarre la session pour suivre les informations sur l'utilisateur
session_start();
require 'mongo_manager.php'; // Inclure le gestionnaire MongoDB

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si non connecté, redirigez l'utilisateur vers la page de connexion
    header("Location: /PHP/connexion.php");
    exit;
}

// Si l'utilisateur est connecté, récupérer les informations de session
$user_id = $_SESSION['user_id'];
$user_role = $_SESSION['role']; // par exemple, 'utilisateur', 'admin'

// Inclure la page d'accueil statique (HTML) en fonction de l'utilisateur
include('/public/HTML/Page_acceuil.html');
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <link rel="stylesheet" href="/public/CSS/index.css">
</head>
<body>

<!-- Message de bienvenue dynamique -->
<div class="welcome-message">
    <h2>Bienvenue, <?php echo htmlspecialchars($user_role); ?> !</h2>
    <p>Vous êtes actuellement connecté en tant que <?php echo htmlspecialchars($user_role); ?>.</p>
</div>

<!-- Navigation générale -->
<nav>
    <ul>
        <li><a href="/PHP/tickets.php">Voir les Tickets</a></li>
        
        <!-- Affichage conditionnel pour l'administrateur -->
        <?php if ($user_role === 'admin'): ?>
            <li><a href="/PHP/gestion_utilisateurs.php">Gérer les Utilisateurs</a></li>
        <?php endif; ?>

        <li><a href="/PHP/logout.php">Se déconnecter</a></li>
    </ul>
</nav>

</body>
</html>
