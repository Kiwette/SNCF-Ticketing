// Fonction pour récupérer et afficher les tickets
async function fetchTickets() {
    try {
        const response = await fetch('php/fetch_tickets.php'); // Appel du fichier PHP
        const tickets = await response.json();  // Transformation de la réponse JSON en objet JavaScript

        const ticketList = document.querySelector('#ticketTable tbody');
        ticketList.innerHTML = '';  // Vider le tableau avant d'ajouter les nouveaux tickets

        // Pour chaque ticket, créer une ligne dans le tableau
        tickets.forEach(ticket => {
            const row = document.createElement('tr');
            row.innerHTML = `
                <td>${ticket.id}</td>
                <td>${ticket.subject}</td>
                <td>${ticket.description}</td>
                <td>${ticket.created_by}</td>
                <td>${ticket.created_at}</td>
                <td>${ticket.category}</td>
                <td>${ticket.priority}</td>
                <td>${ticket.status}</td>
                <td>${ticket.resolution_comment}</td>
                <td>${ticket.action_history}</td>
                <td>
                    <button onclick="deleteTicket(${ticket.id})">Supprimer</button>
                    <button onclick="updateTicket(${ticket.id})">Mettre à jour</button>
                </td>
            `;
            ticketList.appendChild(row);  // Ajouter la ligne au tableau
        });
    } catch (error) {
        console.error('Erreur lors de la récupération des tickets:', error);
    }
}

// Fonction pour supprimer un ticket
async function deleteTicket(ticketId) {
    const response = await fetch('php/delete_ticket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `ticket_id=${ticketId}`
    });

    const result = await response.json();
    if (result.success) {
        alert('Ticket supprimé avec succès');
        fetchTickets();  // Recharger la liste des tickets
    } else {
        alert('Erreur de suppression');
    }
}

// Fonction pour mettre à jour un ticket
async function updateTicket(ticketId) {
    const status = prompt('Entrez le nouveau statut du ticket:');
    const resolution_comment = prompt('Entrez le commentaire de résolution:');
    
    const response = await fetch('php/update_ticket.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: `ticket_id=${ticketId}&status=${status}&resolution_comment=${resolution_comment}`
    });

    const result = await response.json();
    if (result.success) {
        alert('Ticket mis à jour avec succès');
        fetchTickets();  // Recharger la liste des tickets
    } else {
        alert('Erreur de mise à jour');
    }
}

// Initialisation de la page pour récupérer les tickets lors du chargement
window.onload = function() {
    fetchTickets();
};
