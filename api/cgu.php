<?php
// Définir les en-têtes de la réponse pour spécifier que la réponse est au format JSON
header('Content-Type: application/json');

// Données des Conditions Générales d'Utilisation (CGU)
$cgu_data = [
    "introduction" => "Bienvenue sur l'application SNCF Ticketing.",
    "acces" => "L'accès à l'application se fait via un compte utilisateur.",
    "services" => "Les services de SNCF Ticketing permettent de réserver des billets...",
    "propriete" => "Toutes les données présentes sur l'application sont la propriété de SNCF.",
    "responsabilites" => "L'utilisateur est responsable de l'utilisation de l'application...",
    "modifications" => "Les CGU peuvent être modifiées à tout moment par SNCF.",
    "contact" => "Pour toute question, contactez-nous via notre page de support."
];

// Retourner les CGU au format JSON
echo json_encode($cgu_data);
?>
