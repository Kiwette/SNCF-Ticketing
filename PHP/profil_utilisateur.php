<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Inclure le fichier de connexion à la base de données
require_once('db_connect.php');

// Récupérer les informations de l'utilisateur
$user_id = $_SESSION['user_id'];
$query = "SELECT * FROM utilisateurs WHERE user_id = :user_id";
$stmt = $pdo->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

// Mettre à jour les informations de l'utilisateur si le formulaire est soumis
if (isset($_POST['update_profile'])) {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $email = $_POST['email'];
    $mot_de_passe = $_POST['mot_de_passe'];
    
    // Mettre à jour le profil dans la base de données
    $update_query = "UPDATE utilisateurs SET nom = :nom, prenom = :prenom, email = :email, mot_de_passe = :mot_de_passe WHERE user_id = :user_id";
    $stmt_update = $pdo->prepare($update_query);
    $stmt_update->bindParam(':nom', $nom, PDO::PARAM_STR);
    $stmt_update->bindParam(':prenom', $prenom, PDO::PARAM_STR);
    $stmt_update->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt_update->bindParam(':mot_de_passe', $mot_de_passe, PDO::PARAM_STR);
    $stmt_update->bindParam(':user_id', $user_id, PDO::PARAM_INT);
    $stmt_update->execute();
    
    // Rediriger après la mise à jour
    header("Location: profil_utilisateur.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon Profil</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

    <h1>Mon Profil</h1>

    <!-- Formulaire de mise à jour du profil -->
    <form method="POST" action="profil_utilisateur.php">
        <label for="nom">Nom:</label>
        <input type="text" name="nom" value="<?php echo $user['nom']; ?>" required>
        
        <label for="prenom">Prénom:</label>
        <input type="text" name="prenom" value="<?php echo $user['prenom']; ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>" required>
        
        <label for="mot_de_passe">Mot de Passe:</label>
        <input type="password" name="mot_de_passe" required>
        
        <button type="submit" name="update_profile">Mettre à jour</button>
    </form>

</body>
</html>
