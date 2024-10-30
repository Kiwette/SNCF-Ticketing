<?php
session_start();
include 'includes/database.php'; 

// Vérification des permissions
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Administrateur') {
    header("Location: /HTML/page_creation_tickets.html");
    exit();
}

// Gestion de l'ajout et de la modification de ticket
$message = '';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $titre = htmlspecialchars($_POST['titre']);
    $cree_par = htmlspecialchars($_POST['cree_par']);
    $statut = htmlspecialchars($_POST['statut']);
    $priorite = htmlspecialchars($_POST['priorite']);
    $categorie = htmlspecialchars($_POST['categorie']);
    $commentaire_resolution = htmlspecialchars($_POST['commentaire_resolution']);

    if (isset($_GET['id'])) {
        // Mise à jour d'un ticket
        $stmt = $pdo->prepare("UPDATE table_tickets SET titre = ?, cree_par = ?, statut = ?, priorite = ?, categorie = ?, commentaire_resolution = ? WHERE id = ?");
        $stmt->execute([$titre, $cree_par, $statut, $priorite, $categorie, $commentaire_resolution, $_GET['id']]);
        $message = "Ticket mis à jour !";
    } else {
        // Création d'un ticket
        $stmt = $pdo->prepare("INSERT INTO table_tickets (titre, cree_par, statut, priorite, categorie, commentaire_resolution) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$titre, $cree_par, $statut, $priorite, $categorie, $commentaire_resolution]);
        $message = "Ticket créé !";
    }
}

// Récupération des tickets
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
    <link rel="stylesheet" href="/CSS/page_tickets.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function showAlert() {
            alert("Bienvenue sur la page de gestion des tickets, SNCF Ticketing!");
        }
       
        window.onload = function() {
            showAlert();  
        };
    </script>
</head>
<body>
    <header>
        <img src="/Images/logo.news.png" alt="logo_sncf"/>
        <h1>SNCF TICKETING</h1>
        <nav>
            <a href="/HTML/Page_utilisateur.html">Se connecter</a>
            <a href="/HTML/page_creation_profil.html">Créer un compte</a>
        </nav>
    </header>

    <main>
        <h2><?php echo isset($_GET['id']) ? "Éditer un Ticket" : "Créer un Ticket"; ?></h2>

        <?php if ($message): ?>
            <div class='alert alert-success'><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="titre">Titre *</label>
            <input type="text" id="titre" name="titre" required>

            <label for="cree_par">Créé par (ID) *</label>
            <input type="number" id="cree_par" name="cree_par" required>

            <label for="statut">Statut *</label>
            <input type="text" id="statut" name="statut" required>

            <label for="priorite">Priorité *</label>
            <select id="priorite" name="priorite" required>
                <option value="" disabled selected>Choisir une priorité</option>
                <option value="faible">Faible</option>
                <option value="moyenne">Moyenne</option>
                <option value="élevée">Élevée</option>
                <option value="haute">Haute</option>
            </select>

            <label for="categorie">Catégorie *</label>
            <input type="text" id="categorie" name="categorie" required>

            <label for="commentaire_resolution">Commentaire de résolution *</label>
            <textarea id="commentaire_resolution" name="commentaire_resolution" required></textarea>

            <button type="submit"><?php echo isset($_GET['id']) ? "Éditer le Ticket" : "Créer le Ticket"; ?></button>
        </form>

        <!-- Section Liste des tickets -->
        <div class="BlocGénéral">
            <h2 class="titre2">Liste des tickets</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Titre ticket</th>
                        <th>Description du ticket</th>
                        <th>Date de création</th>
                        <th>Date de modification</th>
                        <th>Créé par</th>
                        <th>Catégorie</th>
                        <th>Priorité</th>
                        <th>Statut</th>
                        <th>Date de clôture</th>
                        <th>Commentaire de résolution</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['id']); ?></td>
                        <td><?php echo htmlspecialchars($row['titre']); ?></td>
                        <td><?php echo htmlspecialchars($row['commentaire_resolution']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_creation']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_modif']); ?></td>
                        <td><?php echo htmlspecialchars($row['cree_par']); ?></td>
                        <td><?php echo htmlspecialchars($row['categorie']); ?></td>
                        <td><?php echo htmlspecialchars($row['priorite']); ?></td>
                        <td><?php echo htmlspecialchars($row['statut']); ?></td>
                        <td><?php echo htmlspecialchars($row['date_cloture']); ?></td>
                        <td><?php echo htmlspecialchars($row['commentaire_resolution']); ?></td>
                        <td>
                            <a href="page_ticket.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                            <a href="supprimer_ticket.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce ticket ?');" class="btn btn-danger btn-sm">Supprimer</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </main>

    <footer>
        <h3>SNCF Ticketing | Version 1.1 | <a href="/HTML/cgu.html">CGU</a> | <a href="/HTML/mentions.html">Mentions légales</a></h3>
    </footer>
</body>
</html>

<?php
// Fermer la connexion à la base de données
mysqli_close($conn);
?>
