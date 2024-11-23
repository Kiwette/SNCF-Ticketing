<?php
require 'vendor/autoload.php'; 

// Connexion à MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017"); 
$db = $client->sncf_ticketing; 
$collection = $db->tickets; 

// Fonction pour ajouter un ticket dans MongoDB
function ajouterTicket($titre, $description, $priorite, $categorie, $statut, $departureTime) {
    global $collection;

    $ticket = [
        'titre' => $titre,
        'description' => $description,
        'priorite' => $priorite,
        'categorie' => $categorie,
        'statut' => $statut,
        'departureTime' => new MongoDB\BSON\UTCDateTime(strtotime($departureTime) * 1000)
    ];

    $result = $collection->insertOne($ticket); 
    return $result->getInsertedId(); 
}

// Fonction pour récupérer tous les tickets
function obtenirTickets() {
    global $collection; 
    return $collection->find(); 
}
?>

