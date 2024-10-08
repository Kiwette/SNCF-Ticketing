<?php
session_start();


include 'includes/config.php';


if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Administrateur') {
    header("Location: /HTML/page_creation_tickets.html");
    exit();
}


$sql = "SELECT * FROM table_tickets ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);


if (!$result) {
    die("Erreur lors de la récupération des tickets : " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNCF TICKETING</title>
    <link rel="stylesheet" href="/CSS/gestion_tickets.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="/JS/gestion_tickets.js"></script>
    <script>
        function showAlert() {
            alert("Bienvenue sur la page des tickets, SNCF Ticketing!");
        }
       
        window.onload = function() {
            showAlert();  
        };
    </script>
</head>

<body>
    <section>
        <header class="header">
            <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf" />
            <div class="presentation">
                <h1 class="titre_principal">SNCF TICKETING</h1>
            </div>
            <nav class="nav">
                <li><a href="/HTML/page_creation_tickets.html">Créer un ticket</a></li>
                <li><a href="get_tickets.php">Voir les Tickets</a></li>
                <li><a href="/HTML/Page_accueil.html">Se déconnecter</a></li>
            </nav>
        </header>

        <!-- Section Liste des tickets -->
        <div class="BlocGénéral">
            <div class="Bienvenue">
                <h2 class="titre2"> 
                    <span style="color:#82be00;">Liste des tickets</span>         
                </h2>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre ticket</th>
                        <th>Description du ticket</th>
                        <th>Date de création</th>
                        <th>Date de modification</th>
                        <th>Crée par</th>
                        <th>Catégorie</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Date de clôture</th>
                        <th>Commentaire de résolution</th>
                        <th>Action</th>
                        <th>Historique de l'action</th>                    
                    </tr>
                </thead>
                <tbody>
                    <!-- PHP pour afficher les tickets -->
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['titre_ticket']); ?></td>
                        <td><?php echo htmlspecialchars($row['description_ticket']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_creation_ticket']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_modif_ticket']); ?></td>
                        <td><?php echo htmlspecialchars($row['utilisateur_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['categorie_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['statut_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['priorite_id']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_cloture']); ?></td>
                        <td><?php echo htmlspecialchars($row['cree_par']); ?></td>
                        <td><?php echo htmlspecialchars($row['commentaire_resolution']); ?></td>
                        <td><?php echo htmlspecialchars($row['Action_ticket']); ?></td>
                        <td>
                            <!-- Lien pour modifier ou supprimer un ticket -->
                            <a href="modifier_ticket.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="supprimer_ticket.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <footer class="footer">
            <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2"/>
            <div class="contenu_footer">
                <h3>SNCF Ticketing |
                    <a href="/version.html" class="footer-link">Version 1.1</a> |
                    <a href="/cgu.html" class="footer-link">CGU</a> |
                    <a href="/mentions-legales.html" class="footer-link">Mentions légales</a> |
                    <a href="/HTML/page_contacts.html" class="footer-link"> Contactez-nous</a>
                    e-SNCF ©2024
                </h3>
            </div>
        </footer>
    </section>
</body>
</html>

<?php
// Fermer la connexion à la base de données
mysqli_close($conn);
?>
