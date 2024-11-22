// Fonction pour récupérer et afficher les tickets
async function fetchTickets() {
  try {
      const response = await fetch('fetch_tickets.php'); // Appel du fichier PHP
      const tickets = await response.json();  // Transformation de la réponse JSON en objet JavaScript

      // Sélectionner le corps du tableau dans HTML où les tickets seront affichés
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

// Initialisation de la page pour récupérer les tickets lors du chargement
window.onload = function() {
  fetchTickets();
};
