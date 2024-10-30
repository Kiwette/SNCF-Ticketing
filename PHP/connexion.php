<?php
session_start();
$error = ""; // Initialiser la variable d'erreur

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'databse.php'; // Connexion à la base de données

    // Récupération des données du formulaire
    $email = $_POST['email'];
    $cp = $_POST['cp'];
    $password = $_POST['password'];

    // Requête de vérification de l'utilisateur
    $sql = "SELECT * FROM table_utilisateur WHERE email = ? AND cp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $cp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['user_id'] = $user['id'];
            header("Location: page_tickets.php");
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
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>SNCF TICKETING</title>
    <link rel="stylesheet" href="/SNCF-Ticketing/CSS/connexion.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="/SNCF-Ticketing/JS/connexion.js"></script>
    <script>
      function showAlert() {
          alert("Bienvenue sur votre page de connexion, SNCF Ticketing!");
      }

      window.onload = function() {
          showAlert();  
      };
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
      <h2 class="titre2">Je me connecte à mon espace :<span style="color: #82be00"> SNCF Ticketing </span></h2>      
    </div>

    <!-- Formulaire de connexion -->
    <form id="loginForm" method="POST" action="connexion.php">
        <h1 class="form-title">Je me connecte à mon compte</h1>
        
        <!-- Message d'erreur si la connexion échoue -->
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

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
        <p class="create-account">Je n'ai pas de compte. <a href="/HTML/page_creation_profil.html">Créer un compte</a>.</p>
    </form>       

    <!-- Footer -->
    <footer class="footer">
      <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2"/>
      <div class="contenu_footer">
          <h3>SNCF Ticketing |
              <a href="/version.html" class="footer-link">Version 1.1</a> |
              <a href="/HTML/cgu.html" class="footer-link">CGU</a> | 
              <a href="/HTML/mentions.html" class="footer-link">Mentions légales</a> | 
              <a href="/HTML/page_contacts.html" class="footer-link"> Contactez-nous</a> |
               e-SNCF ©2024 
          </h3>
      </div>
    </footer>
  </section>
</body>
</html>
