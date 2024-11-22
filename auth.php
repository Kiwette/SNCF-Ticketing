<?php
// auth.php

session_start();

// Vérifie si l'utilisateur est connecté et qu'il possède les droits requis
function check_admin() {
    if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
        header("Location: index.php");
        exit;
    }
}

// Vous pouvez aussi créer une fonction pour vérifier si l'utilisateur est connecté en général
function check_logged_in() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: connexion.php");  // Redirection vers la page de connexion
        exit;
    }
}
?>
