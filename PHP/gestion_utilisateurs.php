<?php
include 'auth.php'; // Vérification des droits d'accès
verifier_acces(['administrateur']); // Page accessible uniquement aux administrateurs

// Connexion à la base de données
require 'db_connect.php'; // Connection à la base de données

// Récupération des utilisateurs
$sql = "SELECT u.id_utilisateur, u.nom, u.prenom, u.email, u.role_nom FROM utilisateur u";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion des Utilisateurs</title>
    <link rel="stylesheet" href="/public/assets/HTML/CSS/gestion_utilisateurs.css"> 
</head>
<body>
    <header>
        <h1>Gestion des Utilisateurs</h1>
    </header>

    <main>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= htmlspecialchars($user['id_utilisateur']); ?></td>
                        <td><?= htmlspecialchars($user['nom']); ?></td>
                        <td><?= htmlspecialchars($user['prenom']); ?></td>
                        <td><?= htmlspecialchars($user['email']); ?></td>
                        <td><?= htmlspecialchars($user['role_nom']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>

    <footer>
        <p>&copy; 2024 SNCF Ticketing</p>
    </footer>
</body>
</html>
