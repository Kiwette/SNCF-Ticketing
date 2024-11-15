<?php
session_start(); // Démarrer la session pour vérifier l'authentification

// Vérification si l'utilisateur est authentifié et est un administrateur ou un agent de support
if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'support')) {
    die("Accès non autorisé.");
}

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=sncf_ticketing;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Vérification si la requête est une requête POST et si le CSRF token est valide
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {

    // Validation des données envoyées
    if (isset($_POST['ticket_id'], $_POST['statut']) && is_numeric($_POST['ticket_id'])) {
        $ticket_id = $_POST['ticket_id'];
        $new_status = htmlspecialchars($_POST['statut']); // Sanitize the status

        // Vérification que le statut est valide (par exemple, 'Ouvert', 'En cours', 'Clôturé')
        $valid_statuses = ['Ouvert', 'En cours', 'Clôturé']; // Liste des statuts valides
        if (in_array($new_status, $valid_statuses)) {

            // Requête pour mettre à jour le statut du ticket
            $sql = "UPDATE table_ticket SET statut = :new_status WHERE id_ticket = :ticket_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':new_status', $new_status);
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);

            // Exécuter la requête et vérifier le succès
            if ($stmt->execute()) {
                echo "Statut du ticket mis à jour avec succès.";
            } else {
                echo "Erreur lors de la mise à jour du statut du ticket.";
            }
        } else {
            echo "Statut invalide.";
        }
    } else {
        echo "Données invalides.";
    }
} else {
    echo "Requête invalide ou token CSRF manquant.";
}

?>
