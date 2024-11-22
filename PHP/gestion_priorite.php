<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et s'il a les droits d'administrateur
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    // Si l'utilisateur n'est pas connecté ou n'est pas un admin, rediriger vers la page d'accueil
    header("Location: index.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
require_once('db_connect.php');

// Récupérer la liste des priorités à partir de la base de données
$query = "SELECT * FROM priorites"; // Exemple de requête pour récupérer toutes les priorités
$stmt = $pdo->query($query);
$priorites = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ajouter une nouvelle priorité si un formulaire a été soumis
if (isset($_POST['add_priorite'])) {
    $priorite_name = $_POST['priorite_name'];
    $description = $_POST['description'];

    $insert_query = "INSERT INTO priorites (Nom, Description) VALUES (:priorite_name, :description)";
    $stmt_insert = $pdo->prepare($insert_query);
    $stmt_insert->bindParam(':priorite_name', $priorite_name, PDO::PARAM_STR);
    $stmt_insert->bindParam(':description', $description, PDO::PARAM_STR);
    $stmt_insert->execute();
    header("Location: gestion_priorites.php"); // Recharger la page après ajout
    exit;
}

// Supprimer une priorité si une requête de suppression a été envoyée
if (isset($_POST['delete_priorite'])) {
    $priorite_id = $_POST['priorite_id'];
    $delete_query = "DELETE FROM priorites WHERE Priorite_id = :priorite_id";
    $stmt_delete = $pdo->prepare($delete_query);
    $stmt_delete->bindParam(':priorite_id', $priorite_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: gestion_priorites.php"); // Recharger la page après suppression
    exit;
}

// Mettre à jour une priorité si une requête de mise à jour a été envoyée
if (isset($_POST['update_priorite'])) {
    $priorite_id = $_POST['priorite_id'];
    $new_priorite_name = $_POST['new_priorite_name'];
    $new_description = $_POST['new_description'];

    $update_query = "UPDATE priorites SET Nom = :new_priorite_name, Description = :new_description WHERE Priorite_id = :priorite_id";
    $stmt_update = $pdo->prepare($update_query);
    $stmt_update->bindParam(':new_priorite_name', $new_priorite_name, PDO::PARAM_STR);
    $stmt_update->bindParam(':new_description', $new_description, PDO::PARAM_STR);
    $stmt_update->bindParam(':priorite_id', $priorite_id, PDO::PARAM_INT);
    $stmt_update->execute();
    header("Location: gestion_priorites.php"); // Recharger la page après mise à jour
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Priorités</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <h1>Gestion des Priorités</h1>

    <!-- Formulaire pour ajouter une nouvelle priorité -->
    <form method="POST" action="gestion_priorites.php">
        <label for="priorite_name">Nom de la priorité:</label>
        <input type="text" name="priorite_name" id="priorite_name" required>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <button type="submit" name="add_priorite">Ajouter une priorité</button>
    </form>

    <h2>Liste des Priorités</h2>
    <!-- Table des priorités -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de la priorité</th>
                <th>Description</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Afficher chaque priorité
            foreach ($priorites as $priorite) {
                echo "<tr>";
                echo "<td>" . $priorite['Priorite_id'] . "</td>";
                echo "<td>" . $priorite['Nom'] . "</td>";
                echo "<td>" . $priorite['Description'] . "</td>";
                echo "<td>
                        <!-- Formulaire pour supprimer une priorité -->
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='priorite_id' value='" . $priorite['Priorite_id'] . "'>
                            <button type='submit' name='delete_priorite' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette priorité ?\");'>Supprimer</button>
                        </form>
                        
                        <!-- Formulaire pour mettre à jour une priorité -->
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='priorite_id' value='" . $priorite['Priorite_id'] . "'>
                            <input type='text' name='new_priorite_name' value='" . $priorite['Nom'] . "' required>
                            <textarea name='new_description' required>" . $priorite['Description'] . "</textarea>
                            <button type='submit' name='update_priorite'>Mettre à jour</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
