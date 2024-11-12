<?php
// Configuration de la connexion à la base de données
$host = 'localhost';
$dbname = 'SNCF_TICKETING';
$username = 'root';
$password = '0000';

try {
    // Création de la connexion PDO
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Requête SQL pour récupérer les utilisateurs
    $stmt = $pdo->prepare('SELECT id, nom, prenom, cp, email, role, created_at FROM users');
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Enregistrement de l'erreur dans un fichier log et affichage d'un message générique
    error_log('Erreur de connexion à la base de données: ' . $e->getMessage());
    die('Une erreur est survenue. Veuillez réessayer plus tard.');
}

// Vérification de l'authentification de l'utilisateur (si nécessaire)
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: /HTML/Page_accueil.html'); // Rediriger si l'utilisateur n'est pas connecté
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des utilisateurs - SNCF Ticketing</title>
    <link rel="stylesheet" href="/CSS/gestion_utilisateurs.css" />
</head>
<body>

    <!-- HEADER -->
    <header class="header">
        <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf"/>
        <div class="presentation">
            <h1 class="titre_principal">SNCF TICKETING</h1>
        </div>
        <nav class="nav">
            <ul>
                <li><a href="/HTML/page_creation_tickets.html">Créer un ticket</a></li>
                <li><a href="/HTML/gestion_tickets.html">Gérer les tickets</a></li>
                <li><a href="/HTML/Page_accueil.html">Se déconnecter</a></li>
            </ul>
        </nav>
    </header>

    <!-- SECTION PRINCIPALE -->
    <section class="BlocGénéral">
        <div class="Bienvenue">
            <h2 class="titre2">
                <span>Gestion des utilisateurs</span>
            </h2>
        </div>

        <div class="table-section">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Prénom</th>
                        <th>Numéro CP</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date de Création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Affichage des utilisateurs -->
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['nom']); ?></td>
                            <td><?php echo htmlspecialchars($user['prenom']); ?></td>
                            <td><?php echo htmlspecialchars($user['cp']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td><?php echo htmlspecialchars($user['role']); ?></td>
                            <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                            <td>
                                <a href="modifier_utilisateur.php?id=<?php echo htmlspecialchars($user['id']); ?>">Modifier</a> |
                                <a href="supprimer_utilisateur.php?id=<?php echo htmlspecialchars($user['id']); ?>"
                                   onclick="return confirm('Voulez-vous vraiment supprimer cet utilisateur ?');">Supprimer</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </section>

    <!-- FOOTER -->
    <footer class="footer">
        <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2"/>
        <div class="contenu_footer">
            <h3>SNCF Ticketing |
                <a href="/version.html" class="footer-link">Version 1.1</a> |
                <a href="/cgu.html" class="footer-link">CGU</a> |
                <a href="/mentions.html" class="footer-link">Mentions légales</a> |
                <a href="/HTML/page_contacts.html" class="footer-link"> Contactez-nous</a>
                e-SNCF ©2024
            </h3>
        </div>
    </footer>

</body>
</html>
