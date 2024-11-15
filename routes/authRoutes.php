<?php

// Ajouter des routes d'authentification
$app->post('/login', function ($request, $response, $args) {
    // Récupérer les données du formulaire
    $data = $request->getParsedBody();
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';

    // Logique de vérification (remplacer par la logique réelle)
    if ($email === 'user@example.com' && $password === 'password123') {
        $response->getBody()->write(json_encode(['message' => 'Connexion réussie']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(200);
    } else {
        $response->getBody()->write(json_encode(['message' => 'Identifiants invalides']));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
    }
});

$app->post('/register', function ($request, $response, $args) {
    // Récupérer les données du formulaire d'enregistrement
    $data = $request->getParsedBody();
    $email = $data['email'] ?? '';
    $password = $data['password'] ?? '';
    $role = $data['role'] ?? 'user'; // Par défaut, rôle utilisateur

    // Logique d'enregistrement de l'utilisateur (à remplacer par une vraie logique d'enregistrement)
    $response->getBody()->write(json_encode([
        'message' => 'Utilisateur enregistré avec succès',
        'user' => [
            'email' => $email,
            'role' => $role
        ]
    ]));
    return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
});
