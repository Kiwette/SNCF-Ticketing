<?php
include 'connexion.php'; // Inclure le fichier de connexion

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $titre = $_POST['titre']; // Chaîne de caractères
    $cree_par = $_POST['cree_par']; // Entier
    $statut = $_POST['statut']; // Chaîne de caractères
    $priorite = $_POST['priorite']; // Entier
    $categorie = $_POST['categorie']; // Chaîne de caractères
    $commentaire_resolution = $_POST['commentaire_resolution']; // Chaîne de caractères

    // Préparer la requête d'insertion
    $stmt = $conn->prepare("INSERT INTO table_ticket (titre, cree_par, statut, priorite, categorie, commentaire_resolution) VALUES (?, ?, ?, ?, ?, ?)");
    
    // Lier les paramètres
    // "siisss" indique que les types des variables sont : 
    // s = string, i = integer
    $stmt->bind_param("siisss", $titre, $cree_par, $statut, $priorite, $categorie, $commentaire_resolution);

    // Exécuter la requête
    if ($stmt->execute()) {
        echo "Nouveau ticket ajouté avec succès !";
    } else {
        echo "Erreur : " . $stmt->error; // Afficher l'erreur en cas d'échec
    }

    $stmt->close(); // Fermer le statement
    $conn->close(); // Fermer la connexion
}
?>
