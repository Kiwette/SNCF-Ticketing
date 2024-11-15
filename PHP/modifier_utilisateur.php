<?php
// Connexion à la base de données
$dsn = 'mysql:host=localhost;dbname=sncf_ticketing;charset=utf8';
$username = 'root';
$password = '';

try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Démarrer la session
session_start();

// Vérifier que l'utilisateur est connecté et a un rôle approprié (ex : administrateur)
if ($_SESSION['role'] !== 'admin') {
    die("Accès interdit.");
}

// Validation de l'ID de l'utilisateur
if (isset($_GET['id']) && filter_var($_GET['id'], FILTER_VALIDATE_INT)) {
    $id = $_GET['id'];

    // Requête pour récupérer les informations de l'utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe, afficher un formulaire pour la modification
    if ($user) {
        // Générer un jeton CSRF pour le formulaire
        $csrf_token = bin2hex(random_bytes(32));
        $_SESSION['csrf_token'] = $csrf_token;

        // Afficher le formulaire pré-rempli avec les données de l'utilisateur
        echo '<form action="update_user.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($user['id'], ENT_QUOTES, 'UTF-8') . '">';
        echo '<input type="hidden" name="csrf_token" value="' . htmlspecialchars($csrf_token, ENT_QUOTES, 'UTF-8') . '">';
        echo '<label for="nom">Nom</label><input type="text" name="nom" value="' . htmlspecialchars($user['nom'], ENT_QUOTES, 'UTF-8') . '" required />';
        echo '<label for="prenom">Prénom</label><input type="text" name="prenom" value="' . htmlspecialchars($user['prenom'], ENT_QUOTES, 'UTF-8') . '" required />';
        echo '<label for="email">Email</label><input type="email" name="email" value="' . htmlspecialchars($user['email'], ENT_QUOTES, 'UTF-8') . '" required />';
        echo '<label for="role">Rôle</label><select name="role" required>';
        echo '<option value="admin"' . ($user['role'] == 'admin' ? ' selected' : '') . '>Admin</option>';
        echo '<option value="user"' . ($user['role'] == 'user' ? ' selected' : '') . '>Utilisateur</option>';
        echo '</select>';
        echo '<button type="submit">Mettre à jour</button>';
        echo '</form>';
    } else {
        echo "Utilisateur non trouvé.";
    }
} else {
    echo "ID utilisateur invalide.";
}

?>
