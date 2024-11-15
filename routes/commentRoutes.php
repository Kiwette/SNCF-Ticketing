<?php
use App\Controllers\CommentController;

// Ajouter un commentaire à un ticket (nécessite une authentification)
$app->post('/tickets/{id}/comments', [CommentController::class, 'addComment'])->middleware('auth');

// Voir les commentaires d'un ticket
$app->get('/tickets/{id}/comments', [CommentController::class, 'listComments'])->middleware('auth');

// Supprimer un commentaire (réservé aux administrateurs)
$app->delete('/comments/{commentId}', [CommentController::class, 'deleteComment'])->middleware('auth', 'admin');
