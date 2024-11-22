document.addEventListener("DOMContentLoaded", function() {
    const historyTable = document.getElementById("history-table");
  
    // Récupérer les données de l'historique via AJAX
    fetch("/php/get_history.php")
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          const history = data.history;
          history.forEach(item => {
            const row = document.createElement("tr");
            row.innerHTML = `<td>${item.date}</td><td>${item.action}</td><td>${item.details}</td>`;
            historyTable.appendChild(row);
          });
        } else {
          alert("Erreur lors du chargement de l'historique.");
        }
      })
      .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur de chargement de l'historique.");
      });
  });
  