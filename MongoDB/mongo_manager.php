<?php

require 'vendor/autoload.php'; 

// Connexion à MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");  
$db = $client->sncf_ticketing; 
$collection = $db->tickets;   

/**
 * Fonction pour ajouter un ticket dans MongoDB
 */
function ajouterTicket($categorie, $statut, $priorite) {
    global $collection; 
    
    $ticket = [
        'categorie' => $categorie,
        'statut' => $statut,
        'priorite' => $priorite
    ];

    // Insertion du ticket dans MongoDB et récupération de l'ID du ticket inséré
    return $collection->insertOne($ticket)->getInsertedId();
}

/**
 * Fonction pour obtenir tous les tickets depuis MongoDB
 */
function obtenirTickets() {
    global $collection;  // Accéder à la collection MongoDB
    return $collection->find();  // Retourner tous les tickets dans la collection
}
?>
