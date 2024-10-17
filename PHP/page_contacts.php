<?php


if ($_SERVER["REQUEST_METHOD"] == "POST") {
  
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $cp = $_POST['cp'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validation des données
    if (empty($nom) || empty($email) || empty($message)) {
        $error = "Tous les champs doivent être remplis.";
    } else {
     
        $success = "Votre demande a été envoyée avec succès.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

    <!--HEAD-->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNCF TICKETING</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/page_contacts.css" />
      <script>
        function showAlert() {
            alert("Bienvenue sur la page CONTACTS, SNCF Ticketing!");
        }
       
        window.onload = function() {
            showAlert();  
        };
    </script>

</head>

<!--BODY-->

<body>
    <section>
        <header class="header">
            <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf"/>
               <div class="presentation">
                    <h1 class="titre_principal">SNCF TICKETING</h1>
                </div>
                        <nav class="nav">
                            <li><a href="/HTML/Page_utilisateur.html">Se connecter</a></li>
                            <li><a href="/HTML/page_creation_profil.html">Créer un compte</a></li>
                        </nav>
        </header>  
      

<!--PREMIER BLOC-->
   
            <div class="Bienvenue">
                <h2 class="titre2"> 
                    <span style="color: #00205b;">Bienvenue sur la page CONTACTS</span>
                    <span style="color:#82BE00;"> SNCF Ticketing </span>             
                </h2>
            </div>
            <div class="BlocGénéral">    
            <form onsubmit="return validateForm()">
                <h1>Contactez-nous</h1>
                <div class="separation"></div>
                <div class="corps-formulaire">
                    <div class="gauche">
                        <div class="boite">
                            <label for="nom">Votre nom</label>
                            <input type="text" id="nom" placeholder="Entrez votre nom">
                        </div>
                        <div class="boite">
                            <label for="prenom">Votre prénom</label>
                            <input type="text" id="prenom" placeholder="Entrez votre prénom">
                        </div>
                        <div class="boite">
                            <label for="cp">Votre numéro de CP</label>
                            <input type="text" id="cp" placeholder="Entrez votre numéro de CP">
                        </div>
                        <div class="boite">
                            <label for="email">Votre email</label>
                            <input type="email" id="email" placeholder="Entrez votre email">
                        </div>
                    </div>
                    <div class="droite">
                        <div class="boite">
                            <label for="message">Votre message</label>
                            <textarea id="message" placeholder="Écrivez votre message"></textarea>
                        </div>
                    </div>
                </div>
                <div class="pied-formulaire">
                    <button type="submit">Envoyer</button>
                </div>
            </form>
                       

        <footer class="footer">
            <img class="logo_sncf2" src="/Images/essai.logo.png" alt="logo_sncf2"/>
                <div class="contenu_footer">
                    <h3>SNCF Ticketing |
                        <a href="/version.html"  class="footer-link">Version 1.1</a> |
                        <a href="/cgu.html" class="footer-link">CGU</a> | 
                        <a href="/mentions-legales.html" class="footer-link">Mentions légales</a> | 
                        <a href="/HTML/page_contacts.html" class="footer-link"> Contactez-nous</a> |
                         e-SNCF ©2024 
                    </h3>
                </div>

                        <a href="/HTML/Page_accueil.html" class="icone-home">
                            <i class="fas fa-home"></i> Acceuil
                        </a>
        </footer>
    </section>
   
                         
        <!-- JAVASCRIPT -->
    <script>
        function validateForm() {
            const nom = document.getElementById('nom').value;
            const email = document.getElementById('email').value;
            const demande = document.getElementById('message').value;

            if (nom === "" || email === "" || demande === "") {
                alert("Tous les champs doivent être remplis avant l'envoi.");
                return false;
            }
            alert("Votre demande a été envoyée avec succès, nous vous répondrons dans les plus brefs délais !");
            return true;
        }

const message = document.getElementById('message');
const maxChars = 400;
const counter = document.createElement('div');
counter.id = 'charCounter';
counter.innerHTML = `0/${maxChars}`;
message.parentNode.insertBefore(counter, message.nextSibling);

message.addEventListener('input', function() {
    const charCount = message.value.length;
    counter.innerHTML = `${charCount}/${maxChars}`;
    if (charCount > maxChars) {
        counter.style.color = 'red';
    } else {
        counter.style.color = 'black';
    }
});
</script> 
</body>
</html>