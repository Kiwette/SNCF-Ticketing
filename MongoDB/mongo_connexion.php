<?php
require 'vendor/autoload.php';  // Charger le package MongoDB

// Connexion à MongoDB
$client = new MongoDB\Client("mongodb://localhost:27017");  // URL de connexion MongoDB
$db = $client->sncf_ticketing;  // Nom de la base de données
$collection = $db->tickets;     // Nom de la collection dans la base
?>


