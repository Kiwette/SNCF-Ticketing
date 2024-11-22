<?php
// Démarrer la session
session_start();

// Inclure le fichier d'authentification
require_once('auth.php'); // Vérification de la session, si l'utilisateur est déjà connecté, il sera redirigé

// Inclure le fichier de connexion à la base de données
require_once('db_connect.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $num_cp = trim($_POST['num_cp']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    
    // Vérification si les champs sont vides
    if (empty($num_cp) || empty($mot_de_passe)) {
        $error = "Veuillez remplir tous les champs.";
    } else {
        // Préparer la requête pour vérifier les informations de l'utilisateur dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM utilisateurs WHERE num_cp = ?");
        $stmt->execute([$num_cp]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe et que le mot de passe est correct
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Démarrer la session et enregistrer les informations de l'utilisateur
            $_SESSION['user_id'] = $user['user_id']; // ID de l'utilisateur
            $_SESSION['nom'] = $user['nom'];         // Nom de l'utilisateur
            $_SESSION['prenom'] = $user['prenom'];   // Prénom de l'utilisateur
            $_SESSION['role'] = $user['role'];       // Rôle de l'utilisateur

            // Rediriger l'utilisateur vers la page d'accueil ou une page protégée
            header("Location: page_acceuil.php");
            exit;
        } else {
            // Afficher un message d'erreur en cas d'identifiants incorrects
            $error = "Numéro de CP ou mot de passe incorrect.";
        }
    }
}
?>

<!-- Page HTML pour la connexion -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/public/CSS/connexion.css">
</head>
<body>

    <h1>Se connecter</h1>

    <?php
    // Afficher les erreurs, si existantes
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="connexion.php" method="POST">
        <label for="num_cp">Numéro de CP</label>
        <input type="text" id="num_cp" name="num_cp" required>

        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>

        <button type="submit">Se connecter</button>
    </form>

    <p>Pas encore inscrit ? <a href="inscription.php">Créer un compte</a></p>

</body>
</html>
