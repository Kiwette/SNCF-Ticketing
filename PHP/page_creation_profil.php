<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SNCF TICKETING - Création de Profil</title>
    <link rel="stylesheet" href="/CSS/page_creation_profil.css" />
    <script>
        function validateForm(event) {
            event.preventDefault(); 

            // Récupérer les champs du formulaire
            const nom = document.getElementById("nom").value.trim();
            const prenom = document.getElementById("prenom").value.trim();
            const cp = document.getElementById("cp").value.trim();
            const email = document.getElementById("email").value.trim();
            const mdp = document.getElementById("mdp").value;
            const mdp2 = document.getElementById("mdp2").value;
            const terms = document.getElementById("terms").checked;

            // Effacer les anciens messages d'erreur
            let errorMessage = "";
            document.getElementById("error-message").innerText = "";

            // Validation des champs
            if (!nom || !prenom || !cp || !email || !mdp || !mdp2) {
                errorMessage += "Tous les champs sont requis.\n";
            }

            if (cp.length !== 8) {
                errorMessage += "Le numéro de CP doit contenir exactement 8 caractères.\n";
            }

            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                errorMessage += "Veuillez entrer une adresse e-mail valide.\n";
            }

            if (mdp.length > 8) {
                errorMessage += "Le mot de passe doit contenir au moins 8 caractères.\n";
            }

            if (mdp !== mdp2) {
                errorMessage += "Les mots de passe ne correspondent pas.\n";
            }

            if (!terms) {
                errorMessage += "Vous devez accepter les conditions d'utilisation.\n";
            }

            if (errorMessage) {
                document.getElementById("error-message").innerText = errorMessage;
            } else {
                // Soumet le formulaire si toutes les validations sont réussies
                document.getElementById("signup-form").submit();
            }
        }
    </script>
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

        <!-- Affichage du message d'erreur en JavaScript -->
        <div id="error-message" style="color: red; font-weight: bold;"></div>

        <form id="signup-form" method="POST" action="creation_profil.php" onsubmit="validateForm(event)">
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
            <input type="text" id="cp" name="cp" maxlength="8" required />

            <label>Adresse e-mail</label>
            <input type="email" id="email" name="email" required />

            <label for="mdp">Mot de passe</label>
            <input type="password" id="mdp" name="mdp" required />

            <label for="mdp2">Confirmation du mot de passe</label>
            <input type="password" id="mdp2" name="mdp2" required />

            <input type="checkbox" id="terms" required />
            <label for="terms">J'accepte les conditions</label>

            <input type="submit" value="S'inscrire" />
        </form>

        <footer class="footer">
            <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2" />
            <div class="contenu_footer">
                <h3>SNCF Ticketing | <a href="/version.html" class="footer-link">Version 1.1</a> |
                    <a href="/cgu.html" class="footer-link">CGU</a> |
                    <a href="/mentions-legales.html" class="footer-link">Mentions légales</a> |
                    <a href="/HTML/page_contacts.html" class="footer-link">Contactez-nous</a> | e-SNCF ©2024
                </h3>
            </div>
        </footer>
    </section>
</body>
</html>
