<?php
// Démarre la session
session_start();

// Inclure la connexion à la base de données
require_once('db_connect.php');

// Vérifie si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $mot_de_passe = trim($_POST['mot_de_passe']);
    $confirm_mdp = trim($_POST['confirm_mdp']);
    $role = $_POST['role']; // Récupérer le rôle de l'utilisateur (ex: 'Utilisateur' ou 'Administrateur')
    $num_cp = trim($_POST['num_cp']);

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($mot_de_passe) || empty($confirm_mdp) || empty($role) || empty($num_cp)) {
        $error = "Tous les champs doivent être remplis.";
    } elseif ($mot_de_passe !== $confirm_mdp) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        // Sécuriser les données (par exemple, hachage du mot de passe)
        $mot_de_passe_hache = password_hash($mot_de_passe, PASSWORD_BCRYPT);

        // Préparer la requête pour insérer l'utilisateur dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM table_utilisateur WHERE num_cp = ?");
        $stmt->execute([$num_cp]);
        if ($stmt->rowCount() > 0) {
            $error = "Ce numéro de CP est déjà utilisé.";
        } else {
            // Insérer l'utilisateur dans la base de données
            $stmt = $pdo->prepare("INSERT INTO table_utilisateur (nom, prenom, mot_de_passe, role, num_cp) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nom, $prenom, $mot_de_passe_hache, $role, $num_cp]);

            // Si l'insertion est réussie, rediriger vers la page de connexion
            $_SESSION['success'] = "Votre compte a été créé avec succès. Vous pouvez maintenant vous connecter.";
            header("Location: connexion.php");
            exit;
        }
    }
}
?>

<!-- Page HTML pour l'inscription (formulaire) -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création de Profil</title>
    <link rel="stylesheet" href="/public/CSS/inscription.css">
</head>
<body>

    <h1>Créer un compte</h1>
    
    <?php
    // Afficher les erreurs, si existantes
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>

    <form action="inscription.php" method="POST">
        <label for="nom">Nom</label>
        <input type="text" id="nom" name="nom" required>
        
        <label for="prenom">Prénom</label>
        <input type="text" id="prenom" name="prenom" required>
        
        <label for="mot_de_passe">Mot de passe</label>
        <input type="password" id="mot_de_passe" name="mot_de_passe" required>
        
        <label for="confirm_mdp">Confirmer le mot de passe</label>
        <input type="password" id="confirm_mdp" name="confirm_mdp" required>
        
        <label for="role">Rôle</label>
        <select id="role" name="role" required>
            <option value="Utilisateur">Utilisateur</option>
            <option value="Administrateur">Administrateur</option>
        </select>
        
        <label for="num_cp">Numéro de CP</label>
        <input type="text" id="num_cp" name="num_cp" required>
        
        <button type="submit">S'inscrire</button>
    </form>

    <p>Déjà un compte ? <a href="connexion.php">Se connecter</a></p>

</body>
</html>
