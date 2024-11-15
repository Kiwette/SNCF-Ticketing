<?php
// Connexion à la base de données
require_once 'config/db_connect.php'; // Assurez-vous que le chemin est correct


// Récupérer les tickets depuis la base de données
$query = "SELECT * FROM table_ticket";  // Modifié pour utiliser la table "table_ticket"
$result = mysqli_query($conn, $query);

// Vérifier si des tickets existent
if (mysqli_num_rows($result) > 0) {
    // Afficher les tickets dans une table HTML
    echo "<table border='1'>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Statut</th>
                    <th>Priorité</th>
                    <th>Categorie</th>
                </tr>
            </thead>
            <tbody>";
    
    // Parcourir chaque ticket et afficher les données dans un tableau
    while ($row = mysqli_fetch_assoc($result)) {
        echo "<tr>
                <td>" . htmlspecialchars($row['id']) . "</td>
                <td>" . htmlspecialchars($row['titre']) . "</td>
                <td>" . htmlspecialchars($row['description']) . "</td>
                <td>" . htmlspecialchars($row['statut']) . "</td>
                <td>" . htmlspecialchars($row['priorite']) . "</td>
                <td>" . htmlspecialchars($row['categorie']) . "</td>
              </tr>";
    }

    echo "</tbody></table>";
} else {
    // Si aucun ticket n'est trouvé
    echo "Aucun ticket trouvé.";
}

// Fermer la connexion
mysqli_close($conn);
?>
