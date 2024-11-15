<?php
// Inclure le fichier autoload de Composer pour charger les dépendances
require 'vendor/autoload.php'; 

// Connexion à MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");  // Connexion à MongoDB local
$db = $client->sncf_ticketing; // Sélectionner la base de données "sncf_ticketing"
$collection = $db->tickets;   // Sélectionner la collection "tickets"

function ajouterTicket($origin, $destination, $price, $departureTime) {
    global $collection;  // Accéder à la collection MongoDB

    $ticket = [
        'origin' => $origin,
        'destination' => $destination,
        'price' => $price,
        'departureTime' => new MongoDB\BSON\UTCDateTime($departureTime) // Stockage des dates en format UTC
    ];

    $result = $collection->insertOne($ticket);  // Insérer le ticket dans la collection
    return $result->getInsertedId();  // Retourner l'ID du ticket inséré
}

function obtenirTickets() {
    global $collection;  // Accéder à la collection MongoDB
    return $collection->find();  // Retourner tous les tickets dans la collection
}
?>
