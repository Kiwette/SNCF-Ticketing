<?php
session_start();
require 'config/db_connect.php'; // Connexion à la base de données

// Vérification de l'authentification
if (!isset($_SESSION['user_id'])) {
    die('Utilisateur non authentifié.');
}

$message = '';

// Gestion des actions de mise à jour de ticket
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Mise à jour du ticket
    if (isset($_POST['ticket_id'], $_POST['status'], $_POST['resolution_comment'])) {
        $ticketId = $_POST['ticket_id'];
        $status = $_POST['status'];
        $resolutionComment = $_POST['resolution_comment'];

        $sql = "UPDATE tickets SET status = ?, resolution_comment = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status, $resolutionComment, $ticketId]);

        $message = "Ticket mis à jour avec succès.";
    }
    
    // Création d'un ticket
    elseif (isset($_POST['titre'], $_POST['description'], $_POST['priorite_id'], $_POST['categorie_id'], $_POST['statut_id'])) {
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $priorite_id = $_POST['priorite_id'];
        $categorie_id = $_POST['categorie_id'];
        $statut_id = $_POST['statut_id'];
        $user_id = $_SESSION['user_id'];

        $sql = "INSERT INTO tickets (titre, description, priorite_id, categorie_id, statut_id, user_id, date_creation)
                VALUES (?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$titre, $description, $priorite_id, $categorie_id, $statut_id, $user_id]);

        $message = "Ticket créé avec succès!";
    }
    
    // Ajouter une action pour le ticket
    elseif (isset($_POST['ticket_action'], $_POST['ticket_id'])) {
        $ticketId = $_POST['ticket_id'];
        $ticketAction = $_POST['ticket_action'];
        $userId = $_SESSION['user_id'];

        $sql = "INSERT INTO table_action_ticket (ticket_id, utilisateur_id, action, date_action)
                VALUES (?, ?, ?, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$ticketId, $userId, $ticketAction]);

        $message = "Action ajoutée avec succès.";
    }
}

// Affichage de l'historique des actions du ticket
if (isset($_GET['ticket_id'])) {
    $ticket_id = $_GET['ticket_id'];

    // Requête pour récupérer les actions du ticket
    $sql = "SELECT utilisateur_id, action, date_action FROM table_action_ticket WHERE ticket_id = :ticket_id ORDER BY date_action DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt->execute();

    // Récupérer les actions sous forme de tableau
    $actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Tickets</title>
    <link rel="stylesheet" href="/public/CSS/tickets.css">
</head>
<body>

    <div class="container">
        <h1>Gestion des Tickets</h1>

        <?php if ($message): ?>
            <p style="color: green;"><?php echo htmlspecialchars($message); ?></p>
        <?php endif; ?>

        <!-- Formulaire pour créer un nouveau ticket -->
        <h2>Créer un Ticket</h2>
        <form method="POST">
            <label for="titre">Titre du ticket:</label>
            <input type="text" name="titre" id="titre" required>
            <label for="description">Description:</label>
            <textarea name="description" id="description" required></textarea>
            <label for="priorite_id">Priorité:</label>
            <select name="priorite_id" id="priorite_id" required>
                <option value="1">Faible</option>
                <option value="2">Moyenne</option>
                <option value="3">Haute</option>
            </select>
            <label for="categorie_id">Catégorie:</label>
            <select name="categorie_id" id="categorie_id" required>
                <option value="1">Problème technique</option>
                <option value="2">Demande d'assistance</option>
                <option value="3">Autre</option>
            </select>
            <label for="statut_id">Statut:</label>
            <select name="statut_id" id="statut_id" required>
                <option value="1">Ouvert</option>
                <option value="2">En cours</option>
                <option value="3">Clôturé</option>
            </select>
            <button type="submit">Créer le ticket</button>
        </form>

        <!-- Formulaire pour mettre à jour un ticket -->
        <h2>Mettre à jour un Ticket</h2>
        <form method="POST">
            <label for="ticket_id">ID du ticket:</label>
            <input type="number" name="ticket_id" id="ticket_id" required>
            <label for="status">Statut:</label>
            <select name="status" id="status" required>
                <option value="Ouvert">Ouvert</option>
                <option value="En cours">En cours</option>
                <option value="Clôturé">Clôturé</option>
            </select>
            <label for="resolution_comment">Commentaire de résolution:</label>
            <textarea name="resolution_comment" id="resolution_comment"></textarea>
            <button type="submit">Mettre à jour le ticket</button>
        </form>

        <!-- Formulaire pour ajouter une action -->
        <h2>Ajouter une Action à un Ticket</h2>
        <form method="POST">
            <label for="ticket_action">Action:</label>
            <textarea name="ticket_action" id="ticket_action" required></textarea>
            <label for="ticket_id">ID du ticket:</label>
            <input type="number" name="ticket_id" id="ticket_id" required>
            <button type="submit">Ajouter une action</button>
        </form>

        <!-- Affichage de l'historique des actions d'un ticket -->
        <?php if (isset($actions)): ?>
            <h2>Historique des Actions</h2>
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
                                <td><?php echo htmlspecialchars($action['date_action']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Aucune action n'a été enregistrée pour ce ticket.</p>
            <?php endif; ?>
        <?php endif; ?>
    </div>

</body>
</html>
