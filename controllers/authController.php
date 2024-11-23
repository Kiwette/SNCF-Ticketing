<?php
require_once 'models/UserModel.php';


class AuthController {
    public function register($request, $response, $args) {
        $data = $request->getParsedBody();
        $userModel = new UserModel();

        if ($userModel->createUser($data['username'], $data['email'], password_hash($data['password'], PASSWORD_BCRYPT))) {
            return $response->withJson(['message' => 'Utilisateur créé avec succès'], 201);
        }

        return $response->withJson(['error' => 'Erreur lors de la création de l\'utilisateur'], 500);
    }

    public function login($request, $response, $args) {
        $data = $request->getParsedBody();
        $userModel = new UserModel();
        $user = $userModel->findUserByUsername($data['username']);

        if ($user && password_verify($data['password'], $user['password'])) {
            $issuedAt = time();
            $expirationTime = $issuedAt + 3600; // Expire dans 1 heure
            $payload = [
                'iat' => $issuedAt,
                'exp' => $expirationTime,
                'userId' => $user['id'],
                'role' => $user['role']
            ];

            $jwt = JWT::encode($payload, 'votre_cle_secrète');
            return $response->withJson(['token' => $jwt], 200);
        }

        return $response->withJson(['error' => 'Nom d\'utilisateur ou mot de passe incorrect'], 401);
    }

    public function logout($request, $response, $args) {
        return $response->withJson(['message' => 'Utilisateur déconnecté'], 200);
    }
}
?>
