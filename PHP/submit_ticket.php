<?php
// Inclure la configuration de la base de données
include 'includes/database.php';

// Vérifier si les champs obligatoires sont définis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cp = $_POST['cp'];
    $role = $_POST['role']; // Ce champ ne figure pas dans la table, il peut être ignoré ou inclus dans 'commentaire_resolution'
    $subject = $_POST['subject'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];

    // Validation simple
    if (!empty($cp) && !empty($subject) && !empty($category) && !empty($priority) && !empty($description)) {
        // Insertion dans la base de données
        $query = "INSERT INTO table_ticket (titre, description, crée_par, date_crea, statut, priorite, categorie, commentaire_resolution, historique_action, action_ticket)
                  VALUES (?, ?, ?, NOW(), 'ouvert', ?, ?, '', '', '')";
        $stmt = mysqli_prepare($conn, $query);
        // Remplacer 'Créer_par' par l'identifiant de l'utilisateur si nécessaire
        $created_by = $_SESSION['user_id']; // Assurez-vous d'avoir l'identifiant de l'utilisateur
        mysqli_stmt_bind_param($stmt, 'sssss', $subject, $description, $created_by, $priority, $category);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: page_tickets.html?success=1");
        } else {
            echo "Erreur lors de la création du ticket : " . mysqli_error($conn);
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
mysqli_close($conn);
?>
