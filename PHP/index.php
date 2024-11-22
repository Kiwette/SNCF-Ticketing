<?php
// Démarre la session pour suivre les informations sur l'utilisateur
session_start();

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

<!-- Optionnel : vous pouvez ajouter un message de bienvenue dynamique en fonction de l'utilisateur -->
<div class="welcome-message">
    <h2>Bienvenue, <?php echo htmlspecialchars($user_role); ?> !</h2>
    <p>Vous êtes actuellement connecté en tant que <?php echo htmlspecialchars($user_role); ?>.</p>
</div>

<!-- Ajoutez ici un contenu dynamique comme des liens vers les différentes sections -->
<nav>
    <ul>
        <li><a href="/PHP/tickets.php">Voir les Tickets</a></li>
        <li><a href="/PHP/gestion_utilisateurs.php">Gérer les Utilisateurs</a></li>
        <li><a href="/PHP/logout.php">Se déconnecter</a></li>
    </ul>
</nav>
</body>
</html>
