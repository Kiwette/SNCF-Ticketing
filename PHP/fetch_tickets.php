<?php
// Connexion à la base de données
include 'includes/database.php';

$query = "SELECT * FROM tickets";
$result = mysqli_query($conn, $query);

$tickets = [];
while ($row = mysqli_fetch_assoc($result)) {
    $tickets[] = $row;
}

echo json_encode($tickets);

mysqli_close($conn);
?>
