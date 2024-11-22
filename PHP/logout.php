<?php
session_start();
session_unset(); // Supprime toutes les variables de session
session_destroy(); // Détruit la session
header('Location: /public/HTML/page_connexion.html'); // Redirige vers la page de connexion
exit();
?>
