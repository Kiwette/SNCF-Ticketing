<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SNCF TICKETING</title>
    <link rel="stylesheet" href="/CSS/page_creation_tickets.css" />
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script>
        function showAlert() {
            alert("Bienvenue sur votre page de création de ticket, SNCF Ticketing!");
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

        <?php
        require 'includes/database.php'; 
        $message = '';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $cp = htmlspecialchars($_POST['cp']);
            $category = htmlspecialchars($_POST['category']);
            $subject = htmlspecialchars($_POST['subject']);
            $priority = htmlspecialchars($_POST['priority']);
            $description = htmlspecialchars($_POST['description']);

            if (isset($_GET['id'])) {
                $stmt = $pdo->prepare("UPDATE tickets SET cree_par = ?, category = ?, subject = ?, priority = ?, description = ? WHERE id = ?");
                $stmt->execute([$cp, $category, $subject, $priority, $description, $_GET['id']]);
                $message = "Ticket mis à jour !";
            } else {
                $stmt = $pdo->prepare("INSERT INTO tickets (cree_par, category, subject, priority, description) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$cp, $category, $subject, $priority, $description]);
                $message = "Ticket créé !";
            }
        }
        ?>

        <?php if ($message): ?>
            <div class='alert alert-success'><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST">
            <label for="cp">Numéro de CP *</label>
            <input type="text" id="cp" name="cp" required maxlength="8">

            <label for="category">Rôle *</label>
            <select id="category" name="category" required>
                <option value="" disabled selected>Quel est votre rôle ?</option>
                <option value="technique">Utilisateur</option>
                <option value="service">Administrateur</option>
                <option value="autre">Support technique</option>
            </select>

            <label for="subject">Sujet de l'incident *</label>
            <input type="text" id="subject" name="subject" required>

            <label for="priority">Priorité *</label>
            <select id="priority" name="priority" required>
                <option value="" disabled selected>Choisir une priorité</option>
                <option value="faible">Faible</option>
                <option value="moyenne">Moyenne</option>
                <option value="élevée">Élevée</option>
                <option value="haute">Haute</option>
            </select>

            <label for="description">Description *</label>
            <textarea id="description" name="description" required></textarea>

            <button type="submit"><?php echo isset($_GET['id']) ? "Éditer le Ticket" : "Créer le Ticket"; ?></button>
        </form>
    </main>

    <footer>
        <h3>SNCF Ticketing | Version 1.1 | <a href="/HTML/cgu.html">CGU</a> | <a href="/HTML/mentions.html">Mentions légales</a></h3>
    </footer>
</body>
</html>
