<?php
// api/index.php
require_once 'config/Database.php';
require_once 'controllers/UserController.php';

// Créer une instance de la classe Database
$database = new Database();
$conn = $database->getConnection();

// Vérifier la connexion
if ($conn === null) {
    die("Impossible de se connecter à la base de données.");
}

// Créer une instance du contrôleur utilisateur
$userController = new UserController($conn);

// Récupérer tous les utilisateurs
$users = $userController->getAllUsers();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Affichage des Données</title>
</head>
<body>
    <h1>Liste des Données</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Mot de Passe</th>
                <th>Confirmer le Mot de Passe</th>
                <th>Rôle</th>
                <th>Numéro de CP</th>
                <th>Date de Création</th>
                <th>Statut du Compte</th>
                <th>Notifications</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($utilisateur_id as $ligne) : ?>
                <tr>
                    <td><?= htmlspecialchars($ligne['user_id']); ?></td>
                    <td><?= htmlspecialchars($ligne['nom']); ?></td>
                    <td><?= htmlspecialchars($ligne['prenom']); ?></td>
                    <td><?= htmlspecialchars($ligne['email']); ?></td>
                    <td><?= htmlspecialchars($ligne['Mot_de_passe']); ?></td>
                    <td><?= htmlspecialchars($ligne['Confirm_mdp']); ?></td>
                    <td><?= htmlspecialchars($ligne['Role_id']); ?></td>
                    <td><?= htmlspecialchars($ligne['Numero_CP']); ?></td>
                    <td><?= htmlspecialchars($ligne['Date_creation']); ?></td>
                    <td><?= htmlspecialchars($ligne['Statut_compte']); ?></td>
                    <td><?= htmlspecialchars($ligne['Notifications']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>

<!-- Le code récupère tous les utilisateurs via le contrôleur "UserController" en appelant la méthode "gettAllUsers". Cela sert à centraiser la logique de récupération des données dans le contrôleur.

La table affiche les utilisateurs récupérés. Les données sont sécurisées en utilisant la fonction "htmlspecialchars" pour éviter les attaques XSS.-->
