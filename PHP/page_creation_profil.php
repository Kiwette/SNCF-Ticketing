<?php
// Inclure la configuration de la base de données
include 'includes/database.php';

// Initialiser les variables pour les messages d'erreur et de succès
$error_message = "";
$success_message = "";

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer et filtrer les valeurs du formulaire
    $nom = mysqli_real_escape_string($conn, $_POST['nom']);
    $prenom = mysqli_real_escape_string($conn, $_POST['prenom']);
    $cp = mysqli_real_escape_string($conn, $_POST['cp']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mdp = mysqli_real_escape_string($conn, $_POST['mdp']);
    $mdp2 = mysqli_real_escape_string($conn, $_POST['mdp2']);

    if (empty($nom) || empty($prenom) || empty($cp) || empty($email) || empty($mdp) || empty($mdp2)) {
        $error_message = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Veuillez entrer une adresse e-mail valide.";
    } elseif ($mdp !== $mdp2) {
        $error_message = "Les mots de passe ne correspondent pas.";
    } else {
        
        $password_hash = password_hash($mdp, PASSWORD_DEFAULT);
        $date_creation = date('Y-m-d H:i:s'); // Date de création

        // Préparer la requête SQL pour insérer l'utilisateur
        $sql = "INSERT INTO table_utilisateurs (nom_user, prenom_user, email_user, mot_de_passe_user, Numéro_CP_Agent, date_creation_compte, statut_compte) 
                VALUES ('$nom', '$prenom', '$email', '$password_hash', '$cp', '$date_creation', 'actif')"; 
        if (mysqli_query($conn, $sql)) {
            $success_message = "Votre compte a été créé avec succès !";
        } else {
            $error_message = "Erreur : " . mysqli_error($conn);
        }
    }
}

// Fermer la connexion
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SNCF TICKETING</title>
    <link rel="stylesheet" href="/CSS/page_creation_profil.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" />
</head>

<body>
<section>
    <header class="header">
        <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf" />
        <div class="presentation">
            <h1 class="titre_principal">SNCF TICKETING</h1>
        </div>
    </header>

    <div class="Bienvenue">
        <h2 class="titre2">Je crée mon espace : <span style="color: #82be00"> SNCF Ticketing </span></h2>
    </div>

    <!-- Afficher le message d'erreur ou de succès -->
    <?php if (!empty($error_message)): ?>
        <div class="alert alert-danger"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <h4>INSCRIPTION</h4>
        <hr />
        <div class="name-field">
            <div>
                <label>Nom</label>
                <input type="text" id="nom" name="nom" required />
            </div>
            <div>
                <label>Prénom</label>
                <input type="text" id="prenom" name="prenom" required />
            </div>
        </div>
        <label>Numéro de CP</label>
        <input type="text" id="cp" name="cp" required />
        <label>Adresse e-mail</label>
        <input type="email" id="email" name="email" required />

        <label for="mdp">Mot de passe</label>
        <div class="password-field">
            <input type="password" id="mdp" name="mdp" required />
            <i class="fas fa-eye toggle-password" toggle="#mdp"></i>
        </div>

        <label for="mdp2">Confirmation du mot de passe</label>
        <div class="password-field">
            <input type="password" id="mdp2" name="mdp2" required />
            <i class="fas fa-eye toggle-password" toggle="#mdp2"></i>
        </div>
        <input type="checkbox" id="terms" required />
        <label for="terms">J'accepte les conditions</label>
        <input type="submit" value="S'inscrire" />
        <p>Vous avez déjà un compte ? <a href="/HTML/connexion.html">Se connecter</a></p>
    </form>

    <footer class="footer">
        <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2" />
        <div class="contenu_footer">
            <h3>
                SNCF Ticketing |
                <a href="/version.html" class="footer-link">Version 1.1</a> |
                <a href="/cgu.html" class="footer-link">CGU</a> |
                <a href="/mentions-legales.html" class="footer-link">Mentions légales</a> |
                <a href="/HTML/page_contacts.html" class="footer-link">Contactez-nous</a> | e-SNCF ©2024
            </h3>
        </div>
    </footer>
</section>
</body>
</html>
