<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sécurisation des données du formulaire
    $nom = htmlspecialchars($_POST['nom']);
    $prenom = htmlspecialchars($_POST['prenom']);
    $cp = htmlspecialchars($_POST['cp']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Validation des champs
    if (empty($nom) || empty($prenom) || empty($cp) || empty($email) || empty($message)) {
        echo "Tous les champs doivent être remplis.";
    } else {
        // Envoi d'email (à personnaliser selon votre serveur de messagerie)
        $to = "contact@sncf.com";
        $subject = "Demande de contact - SNCF Ticketing";
        $body = "Nom: $nom\nPrénom: $prenom\nCode Postal: $cp\nEmail: $email\n\nMessage: $message";
        $headers = "From: $email";

        if (mail($to, $subject, $body, $headers)) {
            echo "Votre demande a été envoyée avec succès, nous vous répondrons dans les plus brefs délais !";
        } else {
            echo "Une erreur est survenue, veuillez réessayer plus tard.";
        }
    }
} else {
    echo "Méthode de requête invalide.";
}
?>
