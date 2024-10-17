<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclure la connexion à la base de données
    include 'connexion.php'; 

    // Récupérer les données du formulaire
    $email = $_POST['email'];
    $cp = $_POST['cp'];
    $password = $_POST['password'];

    //  Requête de vérification
    $sql = "SELECT * FROM table_utilisateur WHERE email = ? AND cp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $cp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['mot_de_passe'])) {
            // Authentification réussie, démarrer une session
            session_start();
            $_SESSION['user_id'] = $user['id'];
            header("Location: dashboard.php"); 
            exit();
        } else {
            $error = "Mot de passe incorrect.";
        }
    } else {
        $error = "Aucun utilisateur trouvé avec ces informations.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<!--HEAD-->
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SNCF TICKETING</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="/CSS/connexion.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="/JS/connexion.js"></script>

    <!-- Validation JavaScript -->
    <script>
      function validateForm() {
        // Récupérer les valeurs des champs du formulaire
        var email = document.getElementById("email").value;
        var cp = document.getElementById("cp").value;
        var password = document.getElementById("password").value;
        var errorMessage = "";

        // Vérifier si tous les champs sont remplis
        if (email === "" || cp === "" || password === "") {
          errorMessage = "Tous les champs doivent être remplis.\n";
        }

        // Vérifier que l'email a un format valide
        var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
        if (!emailPattern.test(email)) {
          errorMessage += "Veuillez entrer une adresse e-mail valide.\n";
        }

        // Vérifier que le CP est bien de 8 caractères
        if (cp.length !== 8) {
          errorMessage += "Le numéro de CP doit comporter 8 caractères.\n";
        }

        // Vérifier que le mot de passe a au moins 6 caractères
        if (password.length < 6) {
          errorMessage += "Le mot de passe doit comporter au moins 6 caractères.\n";
        }

        // Si un message d'erreur est présent, afficher une alerte et empêcher la soumission du formulaire
        if (errorMessage !== "") {
          alert(errorMessage);
          return false; // Empêcher la soumission du formulaire
        }

        // Si tout est correct, permettre la soumission
        return true;
      }

      function showAlert() {
        alert("Bienvenue sur votre page de connexion, SNCF Ticketing!");
      }

      // Afficher l'alerte au chargement de la page
      window.onload = function() {
        showAlert();  
      };
    </script>
</head>

<!--BODY-->
<body>
  <section>
    <header class="header">
      <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf" />
      <div class="presentation">
        <h1 class="titre_principal">SNCF TICKETING</h1>
      </div>
      <nav class="nav justify-content-center mb-3">
        <li class="nav-item"><a class="nav-link" href="/HTML/Page_accueil.html">Accueil</a></li>
        <li class="nav-item"><a class="nav-link" href="/HTML/page_creation_profil.html">Créer un compte</a></li>
      </nav>
    </header>

    <!--PREMIER BLOC-->
    <h2 class="titre2">
      <span style="color: #00205b; margin-right: 30px;">Je me connecte à mon espace</span>
      <span style="color:#82BE00;">SNCF Ticketing</span>          
    </h2>

    <!-- Formulaire de connexion -->
    <form id="loginForm" method="POST" action="login.php" onsubmit="return validateForm();"> 
        <h1 class="form-title">Je me connecte à mon compte</h1>
        <div class="inputs">                            
            <label for="email">E-mail *</label>
            <input type="email" id="email" name="email" placeholder="Mon adresse mail" required>
            <label for="cp">Numéro de CP*</label>
            <input type="text" id="cp" name="cp" placeholder="Numéro de CP" maxlength="8" required>                     
            <label for="password">Mot de passe *</label>
            <input type="password" id="password" name="password" placeholder="Mot de passe" required>
        </div>
        <a href="/HTML/page_oubli_mdp.html" class="forgot-password">J'ai oublié mon mot de passe</a>
        <button type="submit" class="submit-btn">Continuer</button>            
    </form>       

   <!--FOOTER-->
   <footer class="footer">
      <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2"/>
      <div class="contenu_footer">
        <h3>SNCF Ticketing |
          <a href="/version.html" class="footer-link">Version 1.1</a> |
          <a href="/HTML/cgu.html" class="footer-link">CGU</a> | 
          <a href="/HTML/mentions.html" class="footer-link">Mentions légales</a> | 
          <a href="/HTML/page_contacts.html" class="footer-link">Contactez-nous</a> |
          e-SNCF ©2024 
        </h3>
      </div>
    </footer>
  </section>
</body>
</html>
