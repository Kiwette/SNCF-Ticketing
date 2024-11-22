<?php
session_start();

// Inclure le fichier CSS pour la mise en forme de la page
echo '<link rel="stylesheet" href="/public/CSS/process_form.php">';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : jeton CSRF invalide.");
    }

    // Sécurisation des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $cp = htmlspecialchars($_POST['cp']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($cp) || empty($email) || empty($message)) {
        echo "<div class='container'><div class='error'>Tous les champs doivent être remplis.</div><a href='/HTML/page_contacts.html' class='back-link'>Retour au formulaire</a></div>";
    } else {
        // Validation de l'email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<div class='container'><div class='error'>L'email fourni est invalide.</div><a href='/HTML/page_contacts.html' class='back-link'>Retour au formulaire</a></div>";
        }

        // Validation du code postal
        if (!preg_match('/^[0-9]{5}$/', $cp)) {
            echo "<div class='container'><div class='error'>Le code postal doit comporter 5 chiffres.</div><a href='/HTML/page_contacts.html' class='back-link'>Retour au formulaire</a></div>";
        }

        // Si tout est valide, envoyer l'email
        else {
            $to = "contact@sncf.com"; // Remplacer par l'email où vous voulez recevoir le message
            $subject = "Demande de contact - SNCF Ticketing";
            $body = "Nom: $nom\nPrénom: $prenom\nCode Postal: $cp\nEmail: $email\n\nMessage: $message";
            $headers = "From: $email";

            if (mail($to, $subject, $body, $headers)) {
                echo "<div class='container'><div class='success'>Votre demande a été envoyée avec succès, nous vous répondrons dans les plus brefs délais !</div><a href='/HTML/page_contacts.html' class='back-link'>Retour au formulaire</a></div>";
            } else {
                echo "<div class='container'><div class='error'>Une erreur est survenue, veuillez réessayer plus tard.</div><a href='/HTML/page_contacts.html' class='back-link'>Retour au formulaire</a></div>";
            }
        }
    }
} else {
    echo "<div class='container'><div class='error'>Méthode de requête invalide.</div><a href='/HTML/page_contacts.html' class='back-link'>Retour au formulaire</a></div>";
}
?>
