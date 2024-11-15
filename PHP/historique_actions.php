<?php
// Connexion à la base de données
include 'includes/database.php';

// Vérifier si 'ticket_id' est bien passé en paramètre et est un entier
if (isset($_GET['ticket_id']) && filter_var($_GET['ticket_id'], FILTER_VALIDATE_INT)) {
    $ticket_id = $_GET['ticket_id'];
} else {
    echo "Identifiant de ticket invalide.";
    exit();  // Arrête l'exécution si l'ID n'est pas valide
}

// Préparer la requête pour récupérer les actions associées au ticket
$sql = "SELECT * FROM table_action_ticket WHERE ticket_id = :ticket_id ORDER BY date_action DESC";
$stmt = $pdo->prepare($sql);
$stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);

// Exécuter la requête et récupérer les résultats
if ($stmt->execute()) {
    $actions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "Une erreur est survenue lors de la récupération des actions du ticket.";
    exit();  // Arrête l'exécution si la requête échoue
}
?>

<!-- Afficher les actions -->
<h2>Historique des actions du ticket #<?php echo htmlspecialchars($ticket_id); ?></h2>

<?php if (count($actions) > 0): ?>
    <ul>
        <?php foreach ($actions as $action): ?>
            <li>
                <?php echo htmlspecialchars($action['date_action']); ?> - <?php echo htmlspecialchars($action['description']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p>Aucune action enregistrée pour ce ticket.</p>
<?php endif; ?>
