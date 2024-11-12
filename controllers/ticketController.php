<?php

// Connexion à la base de données
require_once '../config/database.php';

// Fonction pour récupérer tous les tickets
function getTickets() {
    global $pdo;
    $stmt = $pdo->query("SELECT * FROM tickets");
    $tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($tickets);
}

// Fonction pour créer un ticket
function createTicket() {
    global $pdo;
    $data = json_decode(file_get_contents("php://input"), true);

    // Assurez-vous que toutes les données nécessaires sont présentes
    if (isset($data['subject']) && isset($data['description']) && isset($data['user_id'])) {
        $stmt = $pdo->prepare("INSERT INTO tickets (subject, description, user_id, created_at) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$data['subject'], $data['description'], $data['user_id']]);
        echo json_encode(["message" => "Ticket créé avec succès"]);
    } else {
        echo json_encode(["message" => "Données manquantes pour créer un ticket"]);
    }
}

// Fonction pour récupérer un ticket par ID
function getTicketById($id) {
    global $pdo;
    $stmt = $pdo->prepare("SELECT * FROM tickets WHERE id = ?");
    $stmt->execute([$id]);
    $ticket = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($ticket) {
        echo json_encode($ticket);
    } else {
        echo json_encode(["message" => "Ticket non trouvé"]);
    }
}

?>
