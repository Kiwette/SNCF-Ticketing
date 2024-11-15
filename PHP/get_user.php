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

// Requête pour récupérer tous les utilisateurs
$sql = "SELECT * FROM table_utilisateur";
$stmt = $pdo->query($sql);
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si des utilisateurs existent
if ($users) {
    // Afficher les utilisateurs dans une table HTML
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Statut</th>
                </tr>
            </thead>
            <tbody>";
    
    // Parcourir chaque utilisateur et afficher les données dans un tableau
    foreach ($users as $user) {
        echo "<tr>
                <td>" . htmlspecialchars($user['id']) . "</td>
                <td>" . htmlspecialchars($user['nom']) . "</td>
                <td>" . htmlspecialchars($user['prenom']) . "</td>
                <td>" . htmlspecialchars($user['mail']) . "</td>
                <td>" . htmlspecialchars($user['role']) . "</td>
                <td>" . htmlspecialchars($user['statut_compte']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    // Si aucun utilisateur n'est trouvé
    echo "Aucun utilisateur trouvé.";
}

// Fermer la connexion
$pdo = null;
?>
