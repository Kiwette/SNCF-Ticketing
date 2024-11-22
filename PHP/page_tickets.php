<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
require_once('db_connect.php');

// Récupérer la liste des tickets à partir de la base de données
$query = "SELECT * FROM tickets"; // Exemple de requête pour récupérer tous les tickets
$stmt = $pdo->query($query);
$tickets = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Supprimer un ticket si une requête de suppression a été envoyée
if (isset($_POST['delete_ticket'])) {
    $ticket_id = $_POST['ticket_id'];
    $delete_query = "DELETE FROM tickets WHERE Ticket_id = :ticket_id";
    $stmt_delete = $pdo->prepare($delete_query);
    $stmt_delete->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: page_tickets.php"); // Recharger la page après suppression
    exit;
}

// Mettre à jour un ticket si une requête de mise à jour a été envoyée
if (isset($_POST['update_ticket'])) {
    $ticket_id = $_POST['ticket_id'];
    $new_status = $_POST['new_status'];
    $new_comment = $_POST['new_comment'];

    $update_query = "UPDATE tickets SET statut_id = :new_status, commentaire_resolution = :new_comment WHERE Ticket_id = :ticket_id";
    $stmt_update = $pdo->prepare($update_query);
    $stmt_update->bindParam(':new_status', $new_status, PDO::PARAM_INT);
    $stmt_update->bindParam(':new_comment', $new_comment, PDO::PARAM_STR);
    $stmt_update->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
    $stmt_update->execute();
    header("Location: page_tickets.php"); // Recharger la page après mise à jour
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Tickets</title>
    <link rel="stylesheet" href="/public/CSS/page_tickets.css">
</head>
<body>

    <h1>Liste des Tickets</h1>

    <!-- Table des tickets -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Titre</th>
                <th>Description</th>
                <th>Créé par</th>
                <th>Catégorie</th>
                <th>Priorité</th>
                <th>Statut</th>
                <th>Commentaire de résolution</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Afficher chaque ticket
            foreach ($tickets as $ticket) {
                echo "<tr>";
                echo "<td>" . $ticket['Ticket_id'] . "</td>";
                echo "<td>" . $ticket['Titre'] . "</td>";
                echo "<td>" . $ticket['Description'] . "</td>";
                echo "<td>" . $ticket['Cree_par'] . "</td>";
                echo "<td>" . $ticket['Categorie_id'] . "</td>";  
                echo "<td>" . $ticket['Priorite_id'] . "</td>";  
                echo "<td>" . $ticket['Statut_id'] . "</td>";  
                echo "<td>" . $ticket['Commentaire_resolution'] . "</td>";
                echo "<td>
                        <!-- Formulaire pour supprimer un ticket -->
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='ticket_id' value='" . $ticket['Ticket_id'] . "'>
                            <button type='submit' name='delete_ticket' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer ce ticket ?\");'>Supprimer</button>
                        </form>
                        
                        <!-- Formulaire pour mettre à jour un ticket -->
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='ticket_id' value='" . $ticket['Ticket_id'] . "'>
                            <label for='new_status'>Statut</label>
                            <select name='new_status' required>
                                <option value='1'>En cours</option>
                                <option value='2'>Résolu</option>
                                <option value='3'>Fermé</option>
                            </select>
                            <label for='new_comment'>Commentaire</label>
                            <textarea name='new_comment' required>" . $ticket['Commentaire_resolution'] . "</textarea>
                            <button type='submit' name='update_ticket'>Mettre à jour</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>

