<?php
session_start(); // Démarrer la session pour vérifier l'authentification

// Inclure le fichier d'authentification pour vérifier les droits de l'utilisateur
require_once('auth.php');

// Vérification si l'utilisateur est authentifié et est un administrateur ou un agent de support
check_logged_in();
check_admin(); // Assurez-vous que l'utilisateur est soit admin soit support

// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=sncf_ticketing;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Génération d'un token CSRF pour sécuriser le formulaire
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Traitement de la mise à jour du statut d'un ticket
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
    if (isset($_POST['ticket_id'], $_POST['statut']) && is_numeric($_POST['ticket_id'])) {
        $ticket_id = intval($_POST['ticket_id']);
        $new_status = htmlspecialchars(trim($_POST['statut'])); // Sanitize the status

        // Vérification que le statut est valide
        $valid_statuses = ['Ouvert', 'En cours', 'Clôturé'];
        if (in_array($new_status, $valid_statuses)) {
            // Requête pour mettre à jour le statut du ticket
            $sql = "UPDATE table_ticket SET statut = :new_status WHERE id_ticket = :ticket_id";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':new_status', $new_status, PDO::PARAM_STR);
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt->execute();
            $message = "Statut du ticket mis à jour avec succès.";
        } else {
            $message = "Statut invalide.";
        }
    }
    // Gestion des statuts (ajout, modification, suppression)
    elseif (isset($_POST['add_statut'])) {
        $statut_name = htmlspecialchars(trim($_POST['statut_name']));
        $description = htmlspecialchars(trim($_POST['description']));

        if (!empty($statut_name) && !empty($description)) {
            $insert_query = "INSERT INTO statuts (Nom, Description) VALUES (:statut_name, :description)";
            $stmt_insert = $pdo->prepare($insert_query);
            $stmt_insert->bindParam(':statut_name', $statut_name, PDO::PARAM_STR);
            $stmt_insert->bindParam(':description', $description, PDO::PARAM_STR);
            $stmt_insert->execute();
            header("Location: gestion_statuts.php");
            exit;
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
    }

    // Supprimer un statut
    if (isset($_POST['delete_statut'])) {
        $statut_id = intval($_POST['statut_id']);
        $delete_query = "DELETE FROM statuts WHERE Statut_id = :statut_id";
        $stmt_delete = $pdo->prepare($delete_query);
        $stmt_delete->bindParam(':statut_id', $statut_id, PDO::PARAM_INT);
        $stmt_delete->execute();
        header("Location: gestion_statuts.php");
        exit;
    }

    // Mettre à jour un statut
    if (isset($_POST['update_statut'])) {
        $statut_id = intval($_POST['statut_id']);
        $new_statut_name = htmlspecialchars(trim($_POST['new_statut_name']));
        $new_description = htmlspecialchars(trim($_POST['new_description']));

        if (!empty($new_statut_name) && !empty($new_description)) {
            $update_query = "UPDATE statuts SET Nom = :new_statut_name, Description = :new_description WHERE Statut_id = :statut_id";
            $stmt_update = $pdo->prepare($update_query);
            $stmt_update->bindParam(':new_statut_name', $new_statut_name, PDO::PARAM_STR);
            $stmt_update->bindParam(':new_description', $new_description, PDO::PARAM_STR);
            $stmt_update->bindParam(':statut_id', $statut_id, PDO::PARAM_INT);
            $stmt_update->execute();
            header("Location: gestion_statuts.php");
            exit;
        } else {
            $message = "Veuillez remplir tous les champs.";
        }
    }
}

// Récupérer la liste des statuts
$query = "SELECT * FROM statuts";
$stmt = $pdo->query($query);
$statuts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Statuts</title>
    <link rel="stylesheet" href="/public/CSS/gestion_statuts.css">
</head>
<body>

    <h1>Gestion des Statuts</h1>

    <?php if (isset($message)): ?>
        <p style="color: green;"><?php echo $message; ?></p>
    <?php endif; ?>

    <!-- Formulaire pour mettre à jour un ticket -->
    <h2>Mettre à jour le statut d'un ticket</h2>
    <form method="POST">
        <label for="ticket_id">ID du ticket:</label>
        <input type="number" name="ticket_id" id="ticket_id" required>
        <label for="statut">Statut:</label>
        <select name="statut" id="statut" required>
            <option value="Ouvert">Ouvert</option>
            <option value="En cours">En cours</option>
            <option value="Clôturé">Clôturé</option>
        </select>
        <button type="submit">Mettre à jour</button>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </form>

    <h2>Ajouter un nouveau statut</h2>
    <form method="POST">
        <label for="statut_name">Nom du statut:</label>
        <input type="text" name="statut_name" id="statut_name" required>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <button type="submit" name="add_statut">Ajouter un statut</button>
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
    </form>

    <h2>Liste des Statuts</h2>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du statut</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($statuts as $statut): ?>
                <tr>
                    <td><?php echo htmlspecialchars($statut['Statut_id']); ?></td>
                    <td><?php echo htmlspecialchars($statut['Nom']); ?></td>
                    <td><?php echo htmlspecialchars($statut['Description']); ?></td>
                    <td>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="statut_id" value="<?php echo $statut['Statut_id']; ?>">
                            <button type="submit" name="delete_statut" onclick="return confirm('Confirmer la suppression ?');">Supprimer</button>
                        </form>
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="statut_id" value="<?php echo $statut['Statut_id']; ?>">
                            <input type="text" name="new_statut_name" value="<?php echo htmlspecialchars($statut['Nom']); ?>" required>
                            <textarea name="new_description" required><?php echo htmlspecialchars($statut['Description']); ?></textarea>
                            <button type="submit" name="update_statut">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>
</html>
