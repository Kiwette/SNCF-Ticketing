<?php
use App\Controllers\TicketController;

// Créer un nouveau ticket (nécessite une authentification)
$app->post('/tickets/create', [TicketController::class, 'create'])->middleware('auth');

// Voir les détails d'un ticket (accessible par tous les utilisateurs authentifiés)
$app->get('/tickets/{id}', [TicketController::class, 'view'])->middleware('auth');

// Liste des tickets de l'utilisateur
$app->get('/tickets/my', [TicketController::class, 'listUserTickets'])->middleware('auth');

// Gestion des tickets (nécessite le rôle administrateur)
$app->get('/admin/tickets', [TicketController::class, 'listAllTickets'])->middleware('auth', 'admin');
