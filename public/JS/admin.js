document.addEventListener("DOMContentLoaded", function() {
    const deleteBtns = document.querySelectorAll(".delete-btn");
    const editBtns = document.querySelectorAll(".edit-btn");
  
    deleteBtns.forEach(btn => {
      btn.addEventListener("click", function() {
        const userId = this.closest("tr").querySelector("td").innerText;
  
        if (confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?")) {
          fetch(`/php/delete_user.php?id=${userId}`, {
            method: "GET",
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              alert("Utilisateur supprimé avec succès !");
              location.reload(); // Recharger la page pour afficher la liste mise à jour
            } else {
              alert("Erreur lors de la suppression.");
            }
          })
          .catch(error => {
            console.error("Erreur:", error);
            alert("Erreur lors de la suppression.");
          });
        }
      });
    });
  
    editBtns.forEach(btn => {
      btn.addEventListener("click", function() {
        const userId = this.closest("tr").querySelector("td").innerText;
        // Logique de modification de l'utilisateur (rediriger ou ouvrir un formulaire modal)
        window.location.href = `/page_edit_user.html?id=${userId}`;
      });
    });
  });
  