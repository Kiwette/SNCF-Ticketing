<?php
// Démarrer la session
session_start();

// Inclure le fichier d'authentification
require_once('auth.php'); // Vérifie si l'utilisateur est connecté, sinon le redirige

// Connexion à la base de données
require_once('/config/db_connect.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données envoyées par le formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $cp = $_POST['cp'];
    $email = $_POST['email'];
    $mdp = $_POST['mdp'];
    $mdp2 = $_POST['mdp2'];
    $terms = isset($_POST['terms']) ? true : false;

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($cp) || empty($email) || empty($mdp) || empty($mdp2)) {
        $error_message = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Veuillez entrer une adresse email valide.";
    } elseif ($mdp !== $mdp2) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } elseif (!$terms) {
        $error_message = "Vous devez accepter les conditions.";
    } else {
        // Vérifier si l'email existe déjà dans la base de données
        $stmt = $pdo->prepare("SELECT * FROM table_utilisateur WHERE email = :email");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $error_message = "Un compte existe déjà avec cet email.";
        } else {
            // Hacher le mot de passe
            $hashed_password = password_hash($mdp, PASSWORD_DEFAULT);

            // Préparer l'insertion des données dans la base de données
            $sql = "INSERT INTO table_utilisateur (nom, prenom, cp, email, mot_de_passe, date_crea_compte, role_id) 
                    VALUES (:nom, :prenom, :cp, :email, :mot_de_passe, NOW(), 3)"; // 3 = rôle Utilisateur
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':nom', $nom);
            $stmt->bindParam(':prenom', $prenom);
            $stmt->bindParam(':cp', $cp);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':mot_de_passe', $hashed_password);

            if ($stmt->execute()) {
                $success_message = "Votre compte a été créé avec succès !";
            } else {
                $error_message = "Erreur lors de la création du compte. Veuillez réessayer.";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/CSS/creation_profil.css">
    <title>Création de Profil</title>
</head>
<body>

<h1>Création de Profil</h1>

<!-- Affichage des messages d'erreur ou de succès -->
<?php if (isset($error_message)): ?>
    <div style="color: red;">
        <?php echo htmlspecialchars($error_message); ?>
    </div>
<?php endif; ?>

<?php if (isset($success_message)): ?>
    <div style="color: green;">
        <?php echo htmlspecialchars($success_message); ?>
    </div>
<?php endif; ?>

<!-- Formulaire de création de profil -->
<form method="POST" action="creation_profil.php">
    <label for="nom">Nom :</label>
    <input type="text" name="nom" id="nom" required><br>

    <label for="prenom">Prénom :</label>
    <input type="text" name="prenom" id="prenom" required><br>

    <label for="cp">Code Postal :</label>
    <input type="text" name="cp" id="cp" required><br>

    <label for="email">Email :</label>
    <input type="email" name="email" id="email" required><br>

    <label for="mdp">Mot de passe :</label>
    <input type="password" name="mdp" id="mdp" required><br>

    <label for="mdp2">Confirmer le mot de passe :</label>
    <input type="password" name="mdp2" id="mdp2" required><br>

    <label for="terms">
        <input type="checkbox" name="terms" id="terms"> J'accepte les conditions
    </label><br>

    <button type="submit">Créer le compte</button>
</form>

</body>
</html>
