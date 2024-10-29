<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Réinitialisation du mot de passe - SNCF Ticketing</title>
    <link rel="stylesheet" href="/CSS/page_oubli_mdp.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <header class="header">
        <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf" />
        <h1 class="titre_principal">SNCF TICKETING</h1>
        <nav class="nav justify-content-center mb-3">
            <a class="nav-link" href="/HTML/Page_accueil.html">Accueil</a>
            <a class="nav-link" href="/HTML/page_creation_profil.html">Créer un compte</a>
        </nav>
    </header>

    <div class="container my-4">
        <h2>Réinitialiser mon mot de passe</h2>
        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <p>Veuillez entrer votre adresse e-mail. Un lien pour réinitialiser votre mot de passe vous sera envoyé.</p>
            <input type="email" name="email" placeholder="Adresse e-mail" required />
            <button type="submit">Envoyer le lien de réinitialisation</button>
        </form>

        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = htmlspecialchars($_POST['email']);
            echo "<script>alert('Un lien de réinitialisation a été envoyé à $email.');</script>";
        }
        ?>
    </div>

    <footer class="footer">
        <h3>
            SNCF Ticketing | <a href="/version.html">Version 1.1</a> |
            <a href="/HTML/cgu.html">CGU</a> |
            <a href="/HTML/mentions.html">Mentions légales</a> |
            <a href="/HTML/page_contacts.html">Contactez-nous</a> |
            e-SNCF ©2024
        </h3>
    </footer>
</body>
</html>

    </section>

    <!-- JavaScript Simple -->
    <script>
        document.getElementById('forgotPasswordForm').onsubmit = function() {
            var emailInput = document.getElementById('email').value;
            alert("Un lien de réinitialisation a été envoyé à " + emailInput);
        };
    </script>
</body>
</html>
