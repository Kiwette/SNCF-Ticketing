<?php
// Inclure le fichier d'authentification
require_once('auth.php');

// Vérification de l'authentification et des droits d'administrateur
check_admin();

// Inclure le fichier de connexion à la base de données
require_once __DIR__ . '/app/config/Database.php';


// Récupérer la liste des rôles
$query_roles = "SELECT * FROM roles";
$stmt_roles = $pdo->query($query_roles);
$roles = $stmt_roles->fetchAll(PDO::FETCH_ASSOC);

// Récupérer la liste des utilisateurs
$query_users = "SELECT id, nom, prenom, role FROM utilisateurs";
$stmt_users = $pdo->query($query_users);
$users = $stmt_users->fetchAll(PDO::FETCH_ASSOC);

// Ajouter un nouveau rôle
if (isset($_POST['add_role'])) {
    $role_name = htmlspecialchars($_POST['role_name']);

    if (!empty($role_name)) {
        $insert_query = "INSERT INTO roles (Nom_role) VALUES (:role_name)";
        $stmt_insert = $pdo->prepare($insert_query);
        $stmt_insert->bindParam(':role_name', $role_name, PDO::PARAM_STR);
        $stmt_insert->execute();
        header("Location: gestion_roles.php"); // Recharger la page après ajout
        exit;
    } else {
        $error_message = "Le nom du rôle ne peut pas être vide.";
    }
}




// Supprimer un rôle
if (isset($_POST['delete_role'])) {
    $role_id = (int) $_POST['role_id'];
    $delete_query = "DELETE FROM roles WHERE role_id = :role_id";
    $stmt_delete = $pdo->prepare($delete_query);
    $stmt_delete->bindParam(':role_id', $role_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: gestion_roles.php"); // Recharger la page après suppression
    exit;
}

// Mettre à jour un rôle
if (isset($_POST['update_role'])) {
    $role_id = (int) $_POST['role_id'];
    $new_role_name = htmlspecialchars($_POST['new_role_name']);

    if (!empty($new_role_name)) {
        $update_query = "UPDATE roles SET Nom_role = :new_role_name WHERE role_id = :role_id";
        $stmt_update = $pdo->prepare($update_query);
        $stmt_update->bindParam(':new_role_name', $new_role_name, PDO::PARAM_STR);
        $stmt_update->bindParam(':role_id', $role_id, PDO::PARAM_INT);
        $stmt_update->execute();
        header("Location: gestion_roles.php"); // Recharger la page après mise à jour
        exit;
    } else {
        $error_message = "Le nom du rôle ne peut pas être vide.";
    }
}

// Assigner un rôle à un utilisateur
if (isset($_POST['assign_role'])) {
    $user_id = (int) $_POST['user_id'];
    $new_role = htmlspecialchars($_POST['role']);

    // Vérifier si le rôle est valide
    if (in_array($new_role, array_column($roles, 'Nom_role'))) {
        $update_user_role_query = "UPDATE utilisateurs SET role = :role WHERE id = :user_id";
        $stmt_update_user = $pdo->prepare($update_user_role_query);
        $stmt_update_user->bindParam(':role', $new_role, PDO::PARAM_STR);
        $stmt_update_user->bindParam(':user_id', $user_id, PDO::PARAM_INT);
        $stmt_update_user->execute();
        header("Location: gestion_roles.php"); // Recharger la page après assignation
        exit;
    } else {
        $error_message = "Le rôle sélectionné est invalide.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Rôles</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>

    <h1>Gestion des Rôles</h1>

    <?php if (isset($error_message)): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <!-- Formulaire pour ajouter un nouveau rôle -->
    <form method="POST" action="gestion_roles.php">
        <label for="role_name">Nom du Rôle:</label>
        <input type="text" name="role_name" id="role_name" required>
        <button type="submit" name="add_role">Ajouter un rôle</button>
    </form>

    <h2>Liste des Rôles</h2>
    <!-- Table des rôles -->
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom du rôle</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($roles as $role): ?>
                <tr>
                    <td><?php echo htmlspecialchars($role['role_id']); ?></td>
                    <td><?php echo htmlspecialchars($role['Nom_role']); ?></td>
                    <td>
                        <!-- Formulaire pour supprimer un rôle -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="role_id" value="<?php echo $role['role_id']; ?>">
                            <button type="submit" name="delete_role" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce rôle ?');">Supprimer</button>
                        </form>
                        
                        <!-- Formulaire pour mettre à jour un rôle -->
                        <form method="POST" style="display:inline;">
                            <input type="hidden" name="role_id" value="<?php echo $role['role_id']; ?>">
                            <input type="text" name="new_role_name" value="<?php echo htmlspecialchars($role['Nom_role']); ?>" required>
                            <button type="submit" name="update_role">Mettre à jour</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Assignation des Rôles aux Utilisateurs</h2>
    <form method="POST" action="gestion_roles.php">
        <label for="user_id">Utilisateur:</label>
        <select name="user_id" id="user_id" required>
            <?php foreach ($users as $user): ?>
                <option value="<?php echo $user['id']; ?>">
                    <?php echo htmlspecialchars($user['prenom'] . ' ' . $user['nom']); ?> (Rôle actuel : <?php echo htmlspecialchars($user['role']); ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label for="role">Nouveau Rôle:</label>
        <select name="role" id="role" required>
            <?php foreach ($roles as $role): ?>
                <option value="<?php echo htmlspecialchars($role['Nom_role']); ?>">
                    <?php echo htmlspecialchars($role['Nom_role']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" name="assign_role">Assigner le rôle</button>
    </form>

</body>
</html>
