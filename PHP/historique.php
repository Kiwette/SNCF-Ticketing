<?php
session_start();

// Inclure le fichier d'authentification
require_once('auth.php');

// Vérifier si l'utilisateur est connecté
check_logged_in();

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/app/config/Database.php';


// Enregistrer une nouvelle action dans l'historique
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ticket_id'], $_POST['action'], $_POST['ancienne_valeur'], $_POST['nouvelle_valeur'])) {
    $ticket_id = $_POST['ticket_id'];
    $action = $_POST['action'];
    $ancienne_valeur = $_POST['ancienne_valeur'];
    $nouvelle_valeur = $_POST['nouvelle_valeur'];
    $effectue_par = $_SESSION['user_id'];

    $sql = "INSERT INTO historique_tickets (ticket_id, action, ancienne_valeur, nouvelle_valeur, date_action, effectue_par) 
            VALUES (:ticket_id, :action, :ancienne_valeur, :nouvelle_valeur, NOW(), :effectue_par)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->bindParam(':action', $action);
    $stmt->bindParam(':ancienne_valeur', $ancienne_valeur);
    $stmt->bindParam(':nouvelle_valeur', $nouvelle_valeur);
    $stmt->bindParam(':effectue_par', $effectue_par, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "<script>alert('Action enregistrée dans l’historique.');</script>";
    } else {
        echo "<script>alert('Erreur lors de l’enregistrement de l’historique.');</script>";
    }
}

// Récupérer l'historique des actions
$query = "SELECT h.*, u.nom AS utilisateur_nom, u.prenom AS utilisateur_prenom 
          FROM historique_tickets h 
          LEFT JOIN utilisateurs u ON h.effectue_par = u.user_id 
          ORDER BY h.date_action DESC";
$stmt = $pdo->query($query);
$historique = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historique des Actions</title>
    <link rel="stylesheet" href="/public/CSS/historique.css">
</head>
<body>

    <h1>Historique des Actions</h1>

    <!-- Formulaire pour enregistrer une action -->
    <h2>Ajouter une Action à l'Historique</h2>
    <form method="POST" action="">
        <div>
            <label for="ticket_id">ID du Ticket :</label>
            <input type="number" name="ticket_id" id="ticket_id" required>
        </div>
        <div>
            <label for="action">Action :</label>
            <input type="text" name="action" id="action" required>
        </div>
        <div>
            <label for="ancienne_valeur">Ancienne Valeur :</label>
            <input type="text" name="ancienne_valeur" id="ancienne_valeur" required>
        </div>
        <div>
            <label for="nouvelle_valeur">Nouvelle Valeur :</label>
            <input type="text" name="nouvelle_valeur" id="nouvelle_valeur" required>
        </div>
        <button type="submit">Enregistrer l'Action</button>
    </form>

    <!-- Tableau des actions enregistrées -->
    <h2>Historique des Actions</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Ticket ID</th>
                <th>Action</th>
                <th>Ancienne Valeur</th>
                <th>Nouvelle Valeur</th>
                <th>Date</th>
                <th>Effectué Par</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($historique as $action): ?>
                <tr>
                    <td><?php echo htmlspecialchars($action['historique_id']); ?></td>
                    <td><?php echo htmlspecialchars($action['ticket_id']); ?></td>
                    <td><?php echo htmlspecialchars($action['action']); ?></td>
                    <td><?php echo htmlspecialchars($action['ancienne_valeur']); ?></td>
                    <td><?php echo htmlspecialchars($action['nouvelle_valeur']); ?></td>
                    <td><?php echo htmlspecialchars($action['date_action']); ?></td>
                    <td>
                        <?php 
                        echo htmlspecialchars($action['utilisateur_nom'] . " " . $action['utilisateur_prenom']); 
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
