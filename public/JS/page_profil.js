document.addEventListener("DOMContentLoaded", function() {
    const updateForm = document.getElementById("update-profile-form");
  
    updateForm.addEventListener("submit", function(event) {
      event.preventDefault();
  
      const name = document.getElementById("name").value;
      const email = document.getElementById("email").value;
      
      if (!name || !email) {
        alert("Veuillez remplir tous les champs !");
        return;
      }
  
      const formData = new FormData();
      formData.append("name", name);
      formData.append("email", email);
  
      fetch("/php/update_profile.php", {
        method: "POST",
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Profil mis à jour avec succès !");
        } else {
          alert("Erreur lors de la mise à jour du profil.");
        }
      })
      .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur de mise à jour. Essayez à nouveau.");
      });
    });
  });
  