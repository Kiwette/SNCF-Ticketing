<?php
session_start();
require_once 'auth.php'; // Inclure le fichier d'authentification

// Vérifiez que l'utilisateur est authentifié et a le bon rôle
checkRole('Administrateur'); // Par exemple, vous pouvez vérifier si l'utilisateur est un administrateur

require 'config/db_connect.php';

// Définir un ticket_id (cela pourrait être récupéré dynamiquement via GET ou POST)
$ticket_id = 11; 

// Requête pour récupérer les actions du ticket
$sql = "SELECT utilisateur_id, action, date_action FROM table_action_ticket WHERE ticket_id = :ticket_id ORDER BY date_action DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
$stmt->execute();

// Récupérer les actions sous forme de tableau
$actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/public/CSS/actions_tickets.css">
    <title>Historique des Actions du Ticket</title>
</head>
<body>

    <div class="container">
        <h1>Historique des Actions du Ticket #<?php echo $ticket_id; ?></h1>

        <?php if ($actions): ?>
            <table>
                <thead>
                    <tr>
                        <th>Utilisateur ID</th>
                        <th>Action</th>
                        <th>Date de l'Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($actions as $action): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($action['utilisateur_id']); ?></td>
                            <td><?php echo htmlspecialchars($action['action']); ?></td>
                            <td class="date"><?php echo htmlspecialchars($action['date_action']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Aucune action n'a été enregistrée pour ce ticket.</p>
        <?php endif; ?>
    </div>

</body>
</html>
