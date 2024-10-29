<?php
session_start();

// Vérifiez si l'utilisateur est connecté, sinon redirigez vers la page de connexion
if (!isset($_SESSION['user_id'])) {
    header("Location: connexion.php");
    exit();
}

// Inclure la connexion à la base de données
include 'database.php';

// Récupérer des informations sur l'utilisateur
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT prenom, email, cp FROM utilisateurs WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - SNCF TICKETING</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/profil.css" />
</head>
<body>
    <header class="header">
        <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf" />
        <nav class="nav justify-content-center mb-3">
            <a class="nav-link" href="/HTML/Page_accueil.html">Accueil</a>
            <a class="nav-link" href="/HTML/page_creation_profil.html">Créer un compte</a>
            <a class="nav-link" href="logout.php">Déconnexion</a>
        </nav>
    </header>

    <div class="container my-4">
        <h2>Bienvenue, <?php echo htmlspecialchars($user['prenom']); ?>!</h2>
        <h3>Vos informations</h3>
        <p>Email : <?php echo htmlspecialchars($user['email']); ?></p>
        <p>Code Postal : <?php echo htmlspecialchars($user['cp']); ?></p>
    </div>

    <footer class="footer">
        <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2"/>
        <div class="contenu_footer">
            <h3>SNCF Ticketing |
                <a href="/version.html" class="footer-link">Version 1.1</a> |
                <a href="/HTML/cgu.html" class="footer-link">CGU</a> | 
                <a href="/HTML/mentions.html" class="footer-link">Mentions légales</a> | 
                <a href="/HTML/page_contacts.html" class="footer-link">Contactez-nous</a> |
                e-SNCF ©2024 
            </h3>
        </div>
    </footer>
</body>
</html>
