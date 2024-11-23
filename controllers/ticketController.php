<?php
require_once 'models/TicketModel.php';

class TicketController {
    public function createTicket($request, $response, $args) {
        $data = $request->getParsedBody();
        $ticketModel = new TicketModel();

        if ($ticketModel->createTicket($data['subject'], $data['description'], $data['user_id'])) {
            return $response->withJson(['message' => 'Ticket créé avec succès'], 201);
        }

        return $response->withJson(['error' => 'Erreur lors de la création du ticket'], 500);
    }

    public function getTickets($request, $response, $args) {
        $ticketModel = new TicketModel();
        $tickets = $ticketModel->getTickets();

        return $response->withJson($tickets, 200);
    }
}
?>
