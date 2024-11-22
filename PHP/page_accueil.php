<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page d'Accueil</title>
    <!-- Lien vers un fichier CSS externe (vous pouvez le personnaliser) -->
    <link rel="stylesheet" href="styles.css">
</head>
<body>

    <div class="container">
        <h1>Bienvenue, <?php echo htmlspecialchars($_SESSION['prenom']) . " " . htmlspecialchars($_SESSION['nom']); ?> !</h1>
        <p>Rôle : <?php echo htmlspecialchars($_SESSION['role']); ?></p>

        <!-- Ajout d'un bouton de déconnexion -->
        <a href="logout.php" class="logout-btn">Se déconnecter</a>
    </div>

</body>
</html>
