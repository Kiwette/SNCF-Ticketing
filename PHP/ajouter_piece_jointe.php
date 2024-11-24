<?php
session_start();
require_once 'auth.php'; // Ajout du fichier auth.php pour vérifier l'authentification

require_once __DIR__ . '/app/config/Database.php';


// Vérification de l'envoi de données via le formulaire POST
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['file'])) {
    $file = $_FILES['file'];
    $ticket_id = $_POST['ticket_id'];  // ID du ticket pour lequel l'attachement est effectué
    $ajoute_par = $_POST['ajoute_par'];  // ID de l'utilisateur ajoutant le fichier

    // Sécuriser les variables
    $ticket_id = (int)$ticket_id;
    $ajoute_par = (int)$ajoute_par;

    // Validation du fichier téléchargé
    if ($file['error'] == 0) {
        // Dossier où les fichiers seront stockés
        $target_dir = "uploads/tickets/" . $ticket_id . "/";

        // Créer le dossier si nécessaire
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        // Définir le chemin complet du fichier
        $target_file = $target_dir . basename($file['name']);

        // Vérification de l'extension et de la taille du fichier
        $extensions_valides = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'docx'];
        $type_fichier = pathinfo($file['name'], PATHINFO_EXTENSION);
        $taille_max = 5 * 1024 * 1024; // 5 Mo maximum

        if (!in_array(strtolower($type_fichier), $extensions_valides)) {
            echo "<script>alert('Type de fichier non autorisé.'); window.location.href = 'ticket_details.php?ticket_id=" . $ticket_id . "';</script>";
            exit();
        }

        if ($file['size'] > $taille_max) {
            echo "<script>alert('Le fichier est trop volumineux. Taille maximale : 5 Mo.'); window.location.href = 'ticket_details.php?ticket_id=" . $ticket_id . "';</script>";
            exit();
        }

        // Déplacement du fichier vers le répertoire de destination
        if (move_uploaded_file($file['tmp_name'], $target_file)) {
            // Enregistrer les informations dans la base de données
            $sql = "INSERT INTO table_piece_jointe (ticket_id, nom_fichier, type_fichier, chemin_fichier, date_ajout, ajoute_par) 
                    VALUES (:ticket_id, :nom_fichier, :type_fichier, :chemin_fichier, :date_ajout, :ajoute_par)";
            $stmt = $pdo->prepare($sql);
            $date_ajout = date('Y-m-d H:i:s');
            $stmt->bindParam(':ticket_id', $ticket_id, PDO::PARAM_INT);
            $stmt->bindParam(':nom_fichier', $file['name']);
            $stmt->bindParam(':type_fichier', $type_fichier);
            $stmt->bindParam(':chemin_fichier', $target_file);
            $stmt->bindParam(':date_ajout', $date_ajout);
            $stmt->bindParam(':ajoute_par', $ajoute_par, PDO::PARAM_INT);
            $stmt->execute();

            // Confirmation du téléchargement
            echo "<script>alert('Fichier téléchargé avec succès!'); window.location.href = 'ticket_details.php?ticket_id=" . $ticket_id . "';</script>";
        } else {
            echo "<script>alert('Erreur lors du téléchargement du fichier.'); window.location.href = 'ticket_details.php?ticket_id=" . $ticket_id . "';</script>";
        }
    } else {
        echo "<script>alert('Aucun fichier n\'a été téléchargé.'); window.location.href = 'ticket_details.php?ticket_id=" . $ticket_id . "';</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter une Pièce Jointe</title>
    <link rel="stylesheet" href="/public/CSS/ajouter_piece_jointe.css">
</head>
<body>

    <div class="container">
        <h1>Ajouter une Pièce Jointe au Ticket #<?php echo htmlspecialchars($ticket_id); ?></h1>

        <form action="add_attachment.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Choisir un fichier à télécharger :</label>
                <input type="file" name="file" id="file" required>
            </div>
            <input type="hidden" name="ticket_id" value="<?php echo htmlspecialchars($ticket_id); ?>">
            <input type="hidden" name="ajoute_par" value="<?php echo htmlspecialchars($ajoute_par); ?>">
            <button type="submit">Télécharger</button>
        </form>

    </div>

</body>
</html>
