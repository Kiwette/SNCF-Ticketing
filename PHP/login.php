<?php
// Connexion à la base de données
require 'db_connect.php';

session_start();

// Si la requête est un POST, traiter la connexion
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Vérifier la validité du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur CSRF.");
    }

    // Récupérer et valider les données du formulaire
    $mail = filter_var($_POST['mail'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    // Requête pour récupérer l'utilisateur par mail
    $sql = "SELECT * FROM table_utilisateur WHERE mail = :mail";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':mail', $mail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Vérifier le mot de passe et l’existence de l’utilisateur
    if ($user && password_verify($password, $user['mot_de_passe'])) {
        // Connexion réussie, créer une session sécurisée
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_mail'] = $user['mail'];
        $_SESSION['user_role'] = $user['role']; // Stocker le rôle de l'utilisateur

        // Générer un nouveau jeton CSRF pour la session
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        echo "Connexion réussie";

        // Rediriger l'utilisateur vers la page d'accueil ou le tableau de bord
        header("Location: dashboard.php");
        exit();
    } else {
        echo "Identifiants incorrects"; // Message générique pour éviter de donner trop d'informations
    }
} else {
    // Générer un jeton CSRF pour le formulaire
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Connexion</title>
</head>
<body>
    <h1>Connexion</h1>
    <form method="POST" action="login.php">
        <label for="mail">Email :</label>
        <input type="email" id="mail" name="mail" required>
        <br>
        <label for="password">Mot de passe :</label>
        <input type="password" id="password" name="password" required>
        <br>
        <!-- Inclure le jeton CSRF dans le formulaire -->
        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']); ?>">
        <button type="submit">Se connecter</button>
    </form>
</body>
</html>
