<?php
session_start();

function verifier_acces($roles_autorises) {
    if (!isset($_SESSION['utilisateur'])) {
        header('Location: login.php');
        exit();
    }

    $user_role = $_SESSION['utilisateur']['role_nom'];

    if (!in_array($user_role, $roles_autorises)) {
        header('Location: access_denied.php');
        exit();
    }
}
?>
