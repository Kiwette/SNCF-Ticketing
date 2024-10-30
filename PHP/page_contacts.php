<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $cp = $_POST['cp'] ?? '';
    $email = $_POST['email'] ?? '';
    $message = $_POST['message'] ?? '';

    if (empty($nom) || empty($email) || empty($message)) {
        $error = "Tous les champs doivent être remplis.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Veuillez entrer une adresse e-mail valide.";
    } else {
        $success = "Votre demande a été envoyée avec succès.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <!-- Meta, title, CSS -->
</head>
<body>
    <section>
        <header class="header">
            <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf"/>
            <h1 class="titre_principal">SNCF TICKETING</h1>
            <nav>
                <a href="/HTML/Page_utilisateur.html">Se connecter</a>
                <a href="/HTML/page_creation_profil.html">Créer un compte</a>
            </nav>
        </header>

        <div class="Bienvenue">
            <h2>Bienvenue sur la page CONTACTS SNCF Ticketing</h2>
        </div>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?= $error; ?></div>
        <?php elseif (isset($success)): ?>
            <div class="alert alert-success"><?= $success; ?></div>
        <?php endif; ?>

        <form method="POST" onsubmit="return validateForm()">
            <!-- Form fields -->
        </form>
    </section>

    <script>
        function validateForm() {
            const nom = document.getElementById('nom').value;
            const email = document.getElementById('email').value;
            const message = document.getElementById('message').value;

            if (!nom || !email || !message) {
                alert("Tous les champs doivent être remplis avant l'envoi.");
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
