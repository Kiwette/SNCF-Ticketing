<?php
// Démarrer la session
session_start();

// Supprimer toutes les variables de session
session_unset();

// Détruire la session
session_destroy();

// Si vous utilisez des cookies pour le JWT, vous pouvez les supprimer ici :
setcookie("jwt", "", time() - 3600, "/");  // Le cookie est effacé en définissant son expiration dans le passé

// Rediriger l'utilisateur vers la page de connexion ou d'accueil
header("Location: /HTML/Page_accueil.html");
exit();
?>
