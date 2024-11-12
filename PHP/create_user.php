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

// Vérification de la soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $cp = $_POST['cp'];

    // Valider les données (exemple simple de validation)
    if (empty($nom) || empty($prenom) || empty($email) || empty($cp) || empty($role)) {
        die("Tous les champs doivent être remplis.");
    }

    // Insérer l'utilisateur dans la base de données
    $sql = "INSERT INTO utilisateurs (nom, prenom, email, role, cp) VALUES (?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $role, $cp]);

    echo "Utilisateur créé avec succès ! <a href='/HTML/gestion_utilisateurs.html'>Retourner à la gestion des utilisateurs</a>";
}
?>
