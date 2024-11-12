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

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations actuelles de l'utilisateur
    $sql = "SELECT * FROM utilisateurs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si l'utilisateur existe, afficher un formulaire pour la modification
    if ($user) {
        // Afficher le formulaire pré-rempli avec les données de l'utilisateur
        echo '<form action="update_user.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . $user['id'] . '">';
        echo '<label for="nom">Nom</label><input type="text" name="nom" value="' . $user['nom'] . '" required />';
        echo '<label for="prenom">Prénom</label><input type="text" name="prenom" value="' . $user['prenom'] . '" required />';
        echo '<label for="email">Email</label><input type="email" name="email" value="' . $user['email'] . '" required />';
        echo '<label for="role">Rôle</label><select name="role" required>';
        echo '<option value="admin"' . ($user['role'] == 'admin' ? ' selected' : '') . '>Admin</option>';
        echo '<option value="user"' . ($user['role'] == 'user' ? ' selected' : '') . '>Utilisateur</option>';
        echo '</select>';
        echo '<button type="submit">Mettre à jour</button>';
        echo '</form>';
    }
}
?>
