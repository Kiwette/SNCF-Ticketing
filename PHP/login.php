<?php
session_start();

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['user_id'])) {
    // Si l'utilisateur est déjà connecté, rediriger vers la page d'accueil
    header("Location: /public/HTML/Page_accueil.html");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les valeurs envoyées par le formulaire
    $email = $_POST['email'] ?? '';
    $cp = $_POST['cp'] ?? '';
    $password = $_POST['password'] ?? '';

    // Validation des champs
    if (empty($email) || empty($cp) || empty($password)) {
        echo "<script>alert('Tous les champs doivent être remplis !'); window.history.back();</script>";
        exit();
    }

    // Validation de l'email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Adresse email invalide !'); window.history.back();</script>";
        exit();
    }

    // Connexion à la base de données
    $db = new mysqli('localhost', 'user', 'password', 'db_name'); // Changez les valeurs pour votre configuration
    if ($db->connect_error) {
        die("Échec de la connexion à la base de données : " . $db->connect_error);
    }

    // Requête préparée pour récupérer l'utilisateur avec son email et code postal
    $stmt = $db->prepare("SELECT * FROM users WHERE email = ? AND cp = ?");
    $stmt->bind_param("ss", $email, $cp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Vérification du mot de passe
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            // Le mot de passe est correct, on connecte l'utilisateur
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            header("Location: /public/HTML/Page_accueil.html");
            exit();
        } else {
            echo "<script>alert('Mot de passe incorrect !'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Identifiants incorrects !'); window.history.back();</script>";
    }

    $stmt->close();
    $db->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="/public/CSS/login.css">
</head>
<body>

    <h1>Se connecter</h1>

    <!-- Formulaire de connexion -->
    <form action="connexion.php" method="POST">
        <label for="email">Adresse e-mail</label>
        <input type="email" id="email" name="email" required placeholder="Entrez votre e-mail">

        <label for="cp">Code postal</label>
        <input type="text" id="cp" name="cp" required placeholder="Entrez votre code postal">

        <label for="password">Mot de passe</label>
        <input type="password" id="password" name="password" required placeholder="Entrez votre mot de passe">

        <button type="submit">Se connecter</button>
    </form>

    <p>Vous n'avez pas de compte ? <a href="inscription.php">Créez-en un ici</a></p>

</body>
</html>
