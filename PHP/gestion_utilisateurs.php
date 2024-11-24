<?php
session_start();

// Inclure le fichier d'authentification
require_once('auth.php');

// Inclure la classe Database
require_once __DIR__ . '/app/config/Database.php';

use App\Config\Database;

// Vérifier si l'utilisateur est connecté et s'il a les droits d'administrateur
check_logged_in();
check_admin(); // Vérifie que l'utilisateur a le rôle administrateur (role_id = 1)

// Créer une instance de la classe Database et obtenir la connexion
$database = new Database();
$pdo = $database->getConnection();

// Vérification du jeton CSRF pour protéger contre les attaques CSRF
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de validation CSRF !");
    }
}

// Générer un jeton CSRF si ce n'est pas déjà fait
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // Générer un jeton CSRF
}

// Ajouter un nouvel utilisateur
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role_id = $_POST['role'];
    $statut_compte = 'Actif';
    $date_creation = date('Y-m-d H:i:s');

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("L'email n'est pas valide.");
    }

    // Insertion de l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id, statut_compte, date_creation) 
            VALUES (:nom, :prenom, :email, :mot_de_passe, :role_id, :statut_compte, :date_creation)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':mot_de_passe', $password);
    $stmt->bindParam(':role_id', $role_id, PDO::PARAM_INT);
    $stmt->bindParam(':statut_compte', $statut_compte);
    $stmt->bindParam(':date_creation', $date_creation);
    $stmt->execute();

    echo "<script>alert('Nouvel utilisateur ajouté avec succès !');</script>";
}

// Supprimer un utilisateur
if (isset($_POST['delete_user'])) {
    $user_id = $_POST['user_id'];
    // Validation de l'ID utilisateur pour éviter toute injection SQL
    if (!is_numeric($user_id)) {
        die("ID utilisateur invalide.");
    }

    $delete_query = "DELETE FROM utilisateurs WHERE user_id = :user_id";
    $stmt_delete = $pdo->prepare($delete_query);
    $stmt_delete->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_delete->execute();
    header("Location: gestion_utilisateurs.php");
    exit;
}

// Mettre à jour le rôle d'un utilisateur
if (isset($_POST['update_role'])) {
    $user_id = $_POST['user_id'];
    $new_role = $_POST['new_role'];

    // Validation de l'ID utilisateur et du rôle pour éviter toute injection SQL
    if (!is_numeric($user_id) || !in_array($new_role, [1, 2])) {
        die("Données invalides.");
    }

    $update_query = "UPDATE utilisateurs SET role_id = :new_role WHERE user_id = :user_id";
    $stmt_update = $pdo->prepare($update_query);
    $stmt_update->bindParam(':new_role', $new_role, PDO::PARAM_INT);
    $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_update->execute();
    header("Location: gestion_utilisateurs.php");
    exit;
}

// Récupérer la liste des utilisateurs
$query = "SELECT * FROM utilisateurs";
$stmt = $pdo->query($query);
$utilisateurs = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="/public/CSS/styles.css">
</head>
<body>

<h1>Gestion des Utilisateurs</h1>

<!-- Formulaire pour ajouter un utilisateur -->
<div class="form-container">
    <h2>Ajouter un Nouvel Utilisateur</h2>
    <form method="POST" action="">
        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

        <div>
            <label for="nom">Nom :</label>
            <input type="text" name="nom" id="nom" required>
        </div>
        <div>
            <label for="prenom">Prénom :</label>
            <input type="text" name="prenom" id="prenom" required>
        </div>
        <div>
            <label for="email">Email :</label>
            <input type="email" name="email" id="email" required>
        </div>
        <div>
            <label for="password">Mot de passe :</label>
            <input type="password" name="password" id="password" required>
        </div>
        <div>
            <label for="role">Rôle :</label>
            <select name="role" id="role" required>
                <option value="1">Administrateur</option>
                <option value="2">Utilisateur</option>
            </select>
        </div>
        <button type="submit" name="add_user">Ajouter</button>
    </form>
</div>

<!-- Table des utilisateurs existants -->
<h2>Liste des Utilisateurs</h2>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Email</th>
            <th>Rôle</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($utilisateurs as $utilisateur): ?>
            <tr>
                <td><?php echo htmlspecialchars($utilisateur['user_id']); ?></td>
                <td><?php echo htmlspecialchars($utilisateur['nom']); ?></td>
                <td><?php echo htmlspecialchars($utilisateur['prenom']); ?></td>
                <td><?php echo htmlspecialchars($utilisateur['email']); ?></td>
                <td>
                    <?php
                    $role_query = "SELECT Nom_role FROM roles WHERE role_id = :role_id";
                    $stmt_role = $pdo->prepare($role_query);
                    $stmt_role->bindParam(':role_id', $utilisateur['role_id'], PDO::PARAM_INT);
                    $stmt_role->execute();
                    $role = $stmt_role->fetch(PDO::FETCH_ASSOC)['Nom_role'];
                    echo htmlspecialchars($role);
                    ?>
                </td>
                <td>
                    <!-- Supprimer un utilisateur -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $utilisateur['user_id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <button type="submit" name="delete_user" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?');">Supprimer</button>
                    </form>

                    <!-- Mettre à jour le rôle -->
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="user_id" value="<?php echo $utilisateur['user_id']; ?>">
                        <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                        <label for="new_role">Nouveau rôle</label>
                        <select name="new_role">
                            <option value="1" <?php echo $utilisateur['role_id'] == 1 ? 'selected' : ''; ?>>Administrateur</option>
                            <option value="2" <?php echo $utilisateur['role_id'] == 2 ? 'selected' : ''; ?>>Utilisateur</option>
                        </select>
                        <button type="submit" name="update_role">Mettre à jour</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
