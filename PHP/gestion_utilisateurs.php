<?php
session_start();
include 'includes/database.php';  // Connexion à la base de données

// Vérification du rôle utilisateur pour accéder à cette page
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Administrateur') {
    header("Location: /HTML/page_accueil.html");
    exit();
}

// Traitement de la mise à jour de l'utilisateur
if (isset($_POST['update_user']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $nom = htmlspecialchars(trim($_POST['nom']));
    $email = htmlspecialchars(trim($_POST['email']));

    // Vérification de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert alert-danger'>Adresse email invalide.</div>";
    } else {
        // Requête préparée pour la mise à jour
        $update_sql = "UPDATE utilisateurs SET nom = ?, email = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $nom, $email, $id);

        if ($update_stmt->execute()) {
            echo "<div class='alert alert-success'>L'utilisateur a été mis à jour avec succès.</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de la mise à jour de l'utilisateur.</div>";
        }
        $update_stmt->close();
    }
}

// Logique de suppression d'utilisateur
if (isset($_GET['action']) && $_GET['action'] === 'delete' && isset($_GET['id'])) {
    $userId = intval($_GET['id']); // Convertir l'ID en entier pour plus de sécurité
    $deleteSql = "DELETE FROM utilisateurs WHERE id = ?";
    $deleteStmt = $conn->prepare($deleteSql);
    $deleteStmt->bind_param("i", $userId); // Bind de l'ID

    if ($deleteStmt->execute()) {
        echo "<div class='alert alert-success'>L'utilisateur a été supprimé avec succès.</div>";
    } else {
        echo "<div class='alert alert-danger'>Erreur lors de la suppression de l'utilisateur.</div>";
    }

    $deleteStmt->close();
}

// Récupération de la liste des utilisateurs
$sql = "SELECT * FROM utilisateurs";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <section>
        <header class="header">
            <h1>Gestion des Utilisateurs</h1>
            <nav>
                <a href="ajouter_utilisateur.php" class="btn btn-success">Ajouter un Utilisateur</a>
                <a href="page_accueil.php" class="btn btn-primary">Retour à l'Accueil</a>
            </nav>
        </header>

        <!-- Formulaire de modification d'utilisateur -->
        <?php if (isset($_GET['edit_id'])): 
            $editId = intval($_GET['edit_id']);
            $selectSql = "SELECT * FROM utilisateurs WHERE id = ?";
            $selectStmt = $conn->prepare($selectSql);
            $selectStmt->bind_param("i", $editId);
            $selectStmt->execute();
            $userResult = $selectStmt->get_result();
            $user = $userResult->fetch_assoc();
            ?>
            <h2>Modifier l'Utilisateur</h2>
            <form action="gestion_utilisateur.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">
                <div class="form-group">
                    <label for="nom">Nom</label>
                    <input type="text" class="form-control" name="nom" value="<?php echo htmlspecialchars($user['nom']); ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                </div>
                <button type="submit" name="update_user" class="btn btn-primary">Mettre à jour l'utilisateur</button>
            </form>
        <?php endif; ?>

        <!-- Section Liste des Utilisateurs -->
        <div class="BlocGénéral">
            <h2>Liste des Utilisateurs</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date de Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($result->num_rows > 0): ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['id']); ?></td>
                                <td><?php echo htmlspecialchars($row['nom']); ?></td>
                                <td><?php echo htmlspecialchars($row['prenom']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['role_id']); ?></td>
                                <td><?php echo htmlspecialchars($row['date_creation_compte']); ?></td>
                                <td>
                                    <a href="gestion_utilisateur.php?edit_id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="?action=delete&id=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');" class="btn btn-danger btn-sm">Supprimer</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Aucun utilisateur n'a été trouvé.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <footer class="footer">
            <h3>
                SNCF Ticketing |
                <a href="/version.html" class="footer-link">Version 1.1</a> |
                <a href="/cgu.html" class="footer-link">CGU</a> |
                <a href="/mentions-legales.html" class="footer-link">Mentions légales</a> |
                <a href="/HTML/page_contacts.html" class="footer-link">Contactez-nous</a>
                e-SNCF ©2024
            </h3>
        </footer>
    </section>
</body>
</html>

<?php
// Fermer la connexion à la base de données
$stmt->close();
$conn->close();
?>
