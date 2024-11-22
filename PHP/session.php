<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Récupérer les informations de l'utilisateur depuis la session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name']; // Si tu as stocké le nom dans la session, sinon adapte cette ligne
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Session Utilisateur - SNCF Ticketing</title>
    <link rel="stylesheet" href="/public/CSS/session.css"> 
</head>
<body>

    <div class="container">
        <h1>Informations de Session</h1>

        <div class="session-info">
            <p><strong>ID utilisateur :</strong> <?php echo htmlspecialchars($user_id); ?></p>
            <p><strong>Nom :</strong> <?php echo htmlspecialchars($user_name); ?></p>
            <p><strong>Adresse e-mail :</strong> <?php echo htmlspecialchars($_SESSION['user_email']); // Utiliser la variable session si elle est définie ?></p>
            <p><strong>Rôle :</strong> <?php echo htmlspecialchars($_SESSION['user_role']); // Si tu as stocké le rôle dans la session ?></p>
            <p><strong>Session ID :</strong> <?php echo session_id(); ?></p>
        </div>

        <div class="actions">
            <a href="logout.php" class="btn-logout">Se déconnecter</a>
        </div>
    </div>

</body>
</html>
