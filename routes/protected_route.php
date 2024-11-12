<?php
require_once 'vendor/autoload.php'; // Assurez-vous que le fichier 'vendor/autoload.php' est chargé

use \Firebase\JWT\JWT;

// Clé secrète pour signer et valider les tokens (gardez-la secrète et sécurisée)
$secret_key = "votre_clé_secrète";

// Vérification du token
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Récupérer l'en-tête Authorization
    $headers = apache_request_headers();
    $authHeader = isset($headers['Authorization']) ? $headers['Authorization'] : '';

    if ($authHeader) {
        // Extraire le token du format "Bearer <token>"
        $token = str_replace('Bearer ', '', $authHeader);

        try {
            // Décoder le token avec la clé secrète
            $decoded = JWT::decode($token, $secret_key, array('HS256'));

            // Si le token est valide, accéder à l'utilisateur
            echo json_encode(array("message" => "Accès autorisé", "userId" => $decoded->userId));
        } catch (Exception $e) {
            // Si le token est invalide ou expiré, retour d'une erreur
            header('HTTP/1.1 401 Unauthorized');
            echo json_encode(array(
                "message" => "Token invalide ou expiré",
                "error" => $e->getMessage()
            ));
        }
    } else {
        // Si le token est manquant, retour d'une erreur
        header('HTTP/1.1 401 Unauthorized');
        echo json_encode(array(
            "message" => "Token manquant"
        ));
    }
}
?>
