<?php
use App\Controllers\AdminController;

// Voir tous les utilisateurs
$app->get('/admin/users', [AdminController::class, 'listUsers'])->middleware('auth', 'admin');

// Gérer les tickets (réservé aux administrateurs)
$app->get('/admin/tickets', [AdminController::class, 'manageTickets'])->middleware('auth', 'admin');

// Voir les logs du système (réservé aux administrateurs)
$app->get('/admin/logs', [AdminController::class, 'viewLogs'])->middleware('auth', 'admin');
