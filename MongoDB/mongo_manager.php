<?php
require 'mongo_connection.php';  // Inclure la connexion MongoDB

/**
 * Fonction pour ajouter un ticket dans MongoDB
 */
function ajouterTicket($titre, $description, $priorite, $categorie, $statut) {
    global $collection;  // Accéder à la collection MongoDB

    // Créer un tableau associatif avec les informations du ticket
    $ticket = [
        'titre' => $titre,
        'description' => $description,
        'priorite' => $priorite,
        'categorie' => $categorie,
        'statut' => $statut,
        'date_ajout' => new MongoDB\BSON\UTCDateTime()  // Date et heure actuelles
    ];

    // Insérer le ticket dans la collection MongoDB
    $result = $collection->insertOne($ticket);
    return $result->getInsertedId();  // Retourner l'ID du ticket ajouté
}

/**
 * Fonction pour obtenir tous les tickets depuis MongoDB
 */
function obtenirTickets() {
    global $collection;  // Accéder à la collection MongoDB
    return $collection->find();  // Retourner tous les tickets dans la collection
}

/**
 * Fonction pour obtenir un ticket spécifique par son ID
 */
function obtenirTicketParId($ticketId) {
    global $collection;
    return $collection->findOne(['_id' => new MongoDB\BSON\ObjectId($ticketId)]);
}

/**
 * Fonction pour mettre à jour un ticket
 */
function mettreAJourTicket($ticketId, $updates) {
    global $collection;
    $result = $collection->updateOne(
        ['_id' => new MongoDB\BSON\ObjectId($ticketId)],
        ['$set' => $updates]
    );
    return $result->getModifiedCount(); // Retourne le nombre de documents modifiés
}

/**
 * Fonction pour supprimer un ticket
 */
function supprimerTicket($ticketId) {
    global $collection;
    $result = $collection->deleteOne(['_id' => new MongoDB\BSON\ObjectId($ticketId)]);
    return $result->getDeletedCount();  // Retourne le nombre de tickets supprimés
}
?>
