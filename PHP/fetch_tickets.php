<?php
// Connexion à la base de données
$servername = "localhost"; // Remplacez par votre serveur MySQL
$username = "root"; // Remplacez par votre nom d'utilisateur
$password = ""; // Remplacez par votre mot de passe
$dbname = "sncf_tickets"; // Remplacez par votre nom de base de données

// Création de la connexion
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Requête SQL pour récupérer les tickets
$sql = "SELECT 
            id_ticket, 
            titre, 
            description, 
            crée_par, 
            date_crea, 
            statut, 
            priorite, 
            date_reso, 
            categorie, 
            commentaire_resolution, 
            historique_action, 
            action_ticket 
        FROM table_ticket";
$result = $conn->query($sql);

// Vérification des résultats
$tickets = [];
if ($result->num_rows > 0) {
    // Récupération des données sous forme de tableau associatif
    while($row = $result->fetch_assoc()) {
        $tickets[] = $row;
    }
}

// Retourner les tickets sous forme de JSON
header('Content-Type: application/json');
echo json_encode($tickets);

// Fermeture de la connexion
$conn->close();
?>
