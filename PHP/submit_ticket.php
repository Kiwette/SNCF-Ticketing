<?php
// Inclure la configuration de la base de données
include 'includes/database.php';

// Vérifier si le formulaire est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    

    $titre = mysqli_real_escape_string($conn, $_POST['subject']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $utilisateur_id = (int)$_POST['user_id']; // Assurer que c'est un entier
    $categorie = (int)$_POST['category']; // Assurer que c'est un entier
    $priorite = (int)$_POST['priority']; // Assurer que c'est un entier
    $cree_par = mysqli_real_escape_string($conn, $_POST['created_by']);
    $statut = 'ouvert';
    $commentaire_resolution = ''; 
    $action_ticket = ''; 

    // Préparer la requête SQL
    $stmt = $conn->prepare("INSERT INTO table_tickets (titre_ticket, description_ticket, date_creation_ticket, utilisateur_id, categorie_id, statut_id, priorite_id, cree_par, commentaire_resolution, Action_ticket) VALUES (?, ?, NOW(), ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssiiissss", $titre, $description, $utilisateur_id, $categorie, $statut, $priorite, $cree_par, $commentaire_resolution, $action_ticket);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Le ticket a été créé avec succès.";
    } else {
        echo "Erreur : " . $stmt->error;
    }

    // Fermer la requête
    $stmt->close();
}

// Fermer la connexion à la base de données
$conn->close();
?>
