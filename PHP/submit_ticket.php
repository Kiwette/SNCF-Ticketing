<?php
// Inclure la configuration de la base de données
include 'includes/database.php';

// Vérifier si les champs obligatoires sont définis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $cp = $_POST['cp'];
    $role = $_POST['role'];
    $subject = $_POST['subject'];
    $category = $_POST['category'];
    $priority = $_POST['priority'];
    $description = $_POST['description'];

    // Validation simple (vous pouvez ajouter plus de validations)
    if (!empty($cp) && !empty($role) && !empty($subject) && !empty($category) && !empty($priority) && !empty($description)) {
        // Insertion dans la base de données
        $query = "INSERT INTO tickets (cp, role, subject, category, priority, description, status, created_at)
                  VALUES (?, ?, ?, ?, ?, ?, 'ouvert', NOW())";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, 'ssssss', $cp, $role, $subject, $category, $priority, $description);

        if (mysqli_stmt_execute($stmt)) {
            header("Location: page_tickets.html?success=1");
        } else {
            echo "Erreur lors de la création du ticket.";
        }
    } else {
        echo "Tous les champs sont obligatoires.";
    }
}
mysqli_close($conn);
?>
