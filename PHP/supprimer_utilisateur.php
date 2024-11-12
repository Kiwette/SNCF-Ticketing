
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

    // Supprimer l'utilisateur
    $sql = "DELETE FROM utilisateurs WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);

    echo "Utilisateur supprimé avec succès ! <a href='/HTML/gestion_utilisateurs.html'>Retourner à la gestion des utilisateurs</a>";
}
?>
