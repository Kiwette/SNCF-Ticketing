<?php
require_once 'vendor/autoload.php';  // Si vous utilisez Composer
use \Firebase\JWT\JWT;

$secret_key = "helenedhervillez221291";  // Clé secrète pour signer le token

// Connexion à la base de données
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sncf_ticketing";

// Création de la connexion à la base de données
$conn = new mysqli($servername, $username, $password, $dbname);

// Vérification de la connexion
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Si la requête est de type POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données envoyées
    $data = json_decode(file_get_contents("php://input"));
    $email = $data->email;
    $password = $data->password;

    // Validation de l'email
    if (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        echo json_encode(array("message" => "Email invalide"));
        exit();
    }

    // Utilisation d'une requête préparée pour éviter l'injection SQL
    $stmt = $conn->prepare("SELECT * FROM table_utilisateur WHERE email = ?");
    $stmt->bind_param("s", $email);  // "s" pour string (email)
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Vérifier si le mot de passe est correct
        if (password_verify($password, $user['mot_de_passe'])) {
            // Création du payload pour le JWT
            $payload = array(
                "iss" => "http://example.org",  // Le serveur émetteur
                "aud" => "http://example.com",  // L'audience
                "iat" => time(),  // Heure de création
                "exp" => time() + 3600,  // Le token expire après 1 heure
                "userId" => $user['user_id'],  // Ajout de l'ID utilisateur au payload
            );

            // Générer le token JWT
            $jwt = JWT::encode($payload, $secret_key);

            // Répondre avec le token
            echo json_encode(array('token' => $jwt));
        } else {
            // Le mot de passe est incorrect
            echo json_encode(array("message" => "Identifiants incorrects"));
        }
    } else {
        // L'email n'existe pas dans la base de données
        echo json_encode(array("message" => "Identifiants incorrects"));
    }

    $stmt->close();
}

$conn->close();
?>
