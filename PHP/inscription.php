<?php
// Démarre la session
session_start();

// Inclure la connexion à la base de données
require_once __DIR__ . '/app/config/Database.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    header("Location: /PHP/index.php");
    exit;
}

// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $num_cp = trim($_POST['num_cp']);
    $mot_de_passe = trim($_POST['mot_de_passe']);

    // Validation du champ num_cp
    if (empty($num_cp) || empty($mot_de_passe)) {
        $error = "Tous les champs doivent être remplis.";
    } else {
        // Préparer la requête pour récupérer l'utilisateur avec le numéro de CP
        $stmt = $pdo->prepare("SELECT * FROM table_utilisateur WHERE num_cp = ?");
        $stmt->execute([$num_cp]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifier si l'utilisateur existe
        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Vérifier si le mot de passe doit être re-haché
            if (password_needs_rehash($user['mot_de_passe'], PASSWORD_DEFAULT)) {
                // Hacher à nouveau le mot de passe avec une méthode de hachage plus sécurisée
                $new_hashed_password = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                // Mettre à jour le mot de passe dans la base de données
                $updateStmt = $pdo->prepare("UPDATE table_utilisateur SET mot_de_passe = ? WHERE num_cp = ?");
                $updateStmt->execute([$new_hashed_password, $num_cp]);
            }

            // Si la vérification réussie, démarrer la session de l'utilisateur
            $_SESSION['user_id'] = $user['id'];  // Assurez-vous que l'ID utilisateur existe
            $_SESSION['role'] = $user['role'];
            header("Location: /PHP/index.php");
            exit;
        } else {
            $error = "Numéro de CP ou mot de passe incorrect.";
        }
    }
}
?>

<!-- Formulaire de connexion HTML -->
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

    <p>Pas encore de compte ? <a href="inscription.php">S'inscrire</a></p>

</body>
</html>
