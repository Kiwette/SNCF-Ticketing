<?php
include 'database.phpphp';

// Génération d'un jeton CSRF pour sécuriser le formulaire
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

// Vérification que le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérification du jeton CSRF
    if (!hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        echo "Erreur : attaque CSRF détectée.";
        exit;
    }

    // Récupération des données du formulaire
    $nom = $_POST['nom_user'];
    $prenom = $_POST['prenom_user'];
    $email = $_POST['email_user'];
    $mdp = $_POST['mot_de_passe_user'];
    $mdp2 = $_POST['confirm_mdp'];
    $role = $_POST['role_id'];
    $CP = $_POST['Numéro_CP_Agent'];
    $date_crea = $_POST['date_creation_compte'];
    $statut = $_POST['statut_compte'];
    $historique = $_POST['historique_activite'];
    $notification = $_POST['Notifications'];

    // Validation des données côté serveur
    if (empty($nom) || empty($prenom) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($mdp) || ($mdp !== $mdp2)) {
        echo "Nom, prénom, email, ou mot de passe invalide.";
        exit;
    }

    // Préparation de la requête
    $stmt = $conn->prepare("INSERT INTO utilisateurs (nom, prenom, email, mot_de_passe, role_id, CP, date_creation_compte, statut_compte, historique_activite, Notifications) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssiissss", $nom, $prenom, $email, password_hash($mdp, PASSWORD_DEFAULT), $role, $CP, $date_crea, $statut, $historique, $notification);

    // Exécution de la requête
    if ($stmt->execute()) {
        echo "Nouveau record créé avec succès";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermeture des déclarations et de la connexion
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un nouvel utilisateur</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<form method="POST" action="nouveau_user.php" onsubmit="return validateForm()">
    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

    <label for="nom_user">Nom :</label>
    <input type="text" id="nom_user" name="nom_user" required>

    <label for="prenom_user">Prénom :</label>
    <input type="text" id="prenom_user" name="prenom_user" required>

    <label for="email_user">Email :</label>
    <input type="email" id="email_user" name="email_user" required>

    <label for="mot_de_passe_user">Mot de passe :</label>
    <input type="password" id="mot_de_passe_user" name="mot_de_passe_user" required>

    <label for="confirm_mdp">Confirmation du mot de passe :</label>
    <input type="password" id="confirm_mdp" name="confirm_mdp" required>

    <label for="role_id">Rôle :</label>
    <input type="text" id="role_id" name="role_id">

    <label for="Numéro_CP_Agent">Numéro CP Agent :</label>
    <input type="text" id="Numéro_CP_Agent" name="Numéro_CP_Agent">

    <label for="date_creation_compte">Date de création :</label>
    <input type="date" id="date_creation_compte" name="date_creation_compte">

    <label for="statut_compte">Statut :</label>
    <input type="text" id="statut_compte" name="statut_compte">

    <label for="historique_activite">Historique d'activité :</label>
    <input type="text" id="historique_activite" name="historique_activite">

    <label for="Notifications">Notifications :</label>
    <input type="text" id="Notifications" name="Notifications">

    <button type="submit">Créer utilisateur</button>
</form>

<script>
function validateForm() {
    // Validation côté client
    const nom = document.getElementById('nom_user').value;
    const prenom = document.getElementById('prenom_user').value;
    const email = document.getElementById('email_user').value;
    const password = document.getElementById('mot_de_passe_user').value;
    const confirmPassword = document.getElementById('confirm_mdp').value;

    // Vérification des champs vides
    if (nom === "" || prenom === "" || email === "" || password === "" || confirmPassword === "") {
        alert("Tous les champs sont obligatoires.");
        return false;
    }

    // Vérification de l'adresse email
    const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
    if (!emailPattern.test(email)) {
        alert("Veuillez entrer une adresse email valide.");
        return false;
    }

    // Vérification des mots de passe
    if (password !== confirmPassword) {
        alert("Les mots de passe ne correspondent pas.");
        return false;
    }

    // Tout est valide
    return true;
}
</script>

</body>
</html>
