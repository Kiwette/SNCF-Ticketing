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

// Vérifier si l'utilisateur est connecté et s'il a les droits administratifs
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    die("Accès interdit.");
}

// Vérifier que les données POST existent et que le jeton CSRF est valide
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Vérification du jeton CSRF
    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        die("Erreur de sécurité : jeton CSRF invalide.");
    }

    // Récupérer les données envoyées via le formulaire
    $id = $_POST['id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    // Validation des données
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("L'adresse e-mail est invalide.");
    }

    if (empty($nom) || empty($prenom) || empty($email) || empty($role)) {
        die("Tous les champs sont obligatoires.");
    }

    // Mettre à jour les informations de l'utilisateur
    $sql = "UPDATE utilisateurs SET nom = ?, prenom = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nom, $prenom, $email, $role, $id]);

    // Message de succès
    echo "Utilisateur mis à jour avec succès ! <a href='/HTML'>Retour à la liste des utilisateurs</a>";
}
?>
