<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['user_id'])) {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page de connexion
    header("Location: connexion.php");
    exit;
}

// Connexion à la base de données
require_once __DIR__ . '/app/config/Database.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $cp = $_POST['cp'];
    $description = $_POST['description'];
    $categorie = $_POST['categorie'];
    $priorite = $_POST['priorite'];

    // Vérification de la validité des données
    if (empty($nom) || empty($prenom) || empty($cp) || empty($description) || empty($categorie) || empty($priorite)) {
        die("Tous les champs doivent être remplis.");
    }

    // Vérifier le format du numéro de CP (7 chiffres suivis d'une lettre)
    if (!preg_match("/^[0-9]{7}[A-Za-z]$/", $cp)) {
        die("Le numéro de CP doit être au format valide (7 chiffres suivis d'une lettre).");
    }

    // Préparer la requête d'insertion dans la base de données
    $sql = "INSERT INTO table_ticket (nom, prenom, cp, description, categorie, priorite) 
            VALUES (:nom, :prenom, :cp, :description, :categorie, :priorite)";
    
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':cp', $cp);
    $stmt->bindParam(':description', $description);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':priorite', $priorite);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Ticket créé avec succès.";
    } else {
        echo "Erreur lors de la soumission du ticket.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Création Ticket</title>
    <link rel="stylesheet" href="/public/CSS/page_creation_tickets.css">
</head>
<body>
    <div class="form-container">
        <h4>Créer un nouveau ticket</h4>
        <hr>

        <form action="page_creation_ticket.php" method="POST">
            <div class="name-field">
                <div class="field">
                    <label for="nom">Nom</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="field">
                    <label for="prenom">Prénom</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>

            <div class="field">
                <label for="cp">Code Postal</label>
                <input type="text" id="cp" name="cp" required>
            </div>

            <div class="field">
                <label for="description">Description</label>
                <textarea id="description" name="description" required></textarea>
            </div>

            <div class="field">
                <label for="categorie">Catégorie</label>
                <select id="categorie" name="categorie" required>
                    <option value="">Choisissez une catégorie</option>
                    <option value="Bug">Bug</option>
                    <option value="Amélioration">Amélioration</option>
                    <option value="Demande">Demande</option>
                </select>
            </div>

            <div class="field">
                <label for="priorite">Priorité</label>
                <select id="priorite" name="priorite" required>
                    <option value="">Choisissez la priorité</option>
                    <option value="Haute">Haute</option>
                    <option value="Moyenne">Moyenne</option>
                    <option value="Basse">Basse</option>
                </select>
            </div>

            <button type="submit">Créer le ticket</button>
        </form>
    </div>
</body>
</html>
