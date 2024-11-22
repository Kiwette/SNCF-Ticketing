<?php
// Démarrer la session
session_start();

// Inclure le fichier d'authentification
require_once('auth.php'); // Vérifie si l'utilisateur est connecté et a les droits appropriés

// Vérifier si l'utilisateur a les droits d'administrateur (role_id = 1)
if (!isset($_SESSION['user_id']) || $_SESSION['role_id'] != 1) {
    // Si l'utilisateur n'est pas un administrateur, rediriger vers la page d'accueil
    header("Location: index.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
require_once('db_connect.php');

// Récupérer la liste des catégories à partir de la base de données
$query = "SELECT * FROM categories"; // Exemple de requête pour récupérer toutes les catégories
$stmt = $pdo->query($query);
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Ajouter une nouvelle catégorie si un formulaire a été soumis
if (isset($_POST['add_category'])) {
    $category_name = $_POST['category_name'];

    $insert_query = "INSERT INTO categories (Nom_categorie) VALUES (:category_name)";
    $stmt_insert = $pdo->prepare($insert_query);
    $stmt_insert->bindParam(':category_name', $category_name, PDO::PARAM_STR);
    $stmt_insert->execute();
    header("Location: gestion_categories.php"); // Recharger la page après ajout
    exit;
}

// Supprimer une catégorie si une requête de suppression a été envoyée
if (isset($_POST['delete_category'])) {
    $category_id = $_POST['category_id'];
    $delete_query = "DELETE FROM categories WHERE Categorie_id = :category_id";
    $stmt_delete = $pdo->prepare($delete_query);
    $stmt_delete->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: gestion_categories.php"); // Recharger la page après suppression
    exit;
}

// Mettre à jour une catégorie si une requête de mise à jour a été envoyée
if (isset($_POST['update_category'])) {
    $category_id = $_POST['category_id'];
    $new_category_name = $_POST['new_category_name'];

    $update_query = "UPDATE categories SET Nom_categorie = :new_category_name WHERE Categorie_id = :category_id";
    $stmt_update = $pdo->prepare($update_query);
    $stmt_update->bindParam(':new_category_name', $new_category_name, PDO::PARAM_STR);
    $stmt_update->bindParam(':category_id', $category_id, PDO::PARAM_INT);
    $stmt_update->execute();
    header("Location: gestion_categories.php"); // Recharger la page après mise à jour
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Catégories</title>
    <link rel="stylesheet" href="/public/CSS/gestion_categories.css">
</head>
<body>

    <h1>Gestion des Catégories</h1>

    <!-- Formulaire pour ajouter une nouvelle catégorie -->
    <form method="POST" action="gestion_categories.php">
        <label for="category_name">Nom de la catégorie:</label>
        <input type="text" name="category_name" id="category_name" required>
        <button type="submit" name="add_category">Ajouter une catégorie</button>
    </form>

    <h2>Liste des Catégories</h2>
    <!-- Table des catégories -->
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom de la catégorie</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Afficher chaque catégorie
            foreach ($categories as $category) {
                echo "<tr>";
                echo "<td>" . $category['Categorie_id'] . "</td>";
                echo "<td>" . $category['Nom_categorie'] . "</td>";
                echo "<td>
                        <!-- Formulaire pour supprimer une catégorie -->
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='category_id' value='" . $category['Categorie_id'] . "'>
                            <button type='submit' name='delete_category' onclick='return confirm(\"Êtes-vous sûr de vouloir supprimer cette catégorie ?\");'>Supprimer</button>
                        </form>
                        
                        <!-- Formulaire pour mettre à jour le nom d'une catégorie -->
                        <form method='POST' style='display:inline;'>
                            <input type='hidden' name='category_id' value='" . $category['Categorie_id'] . "'>
                            <input type='text' name='new_category_name' value='" . $category['Nom_categorie'] . "' required>
                            <button type='submit' name='update_category'>Mettre à jour</button>
                        </form>
                    </td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>

</body>
</html>
