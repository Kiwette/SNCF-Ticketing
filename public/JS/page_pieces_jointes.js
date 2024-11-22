document.addEventListener("DOMContentLoaded", function() {
    const fileForm = document.getElementById("file-form");
  
    fileForm.addEventListener("submit", function(event) {
      event.preventDefault();
      
      const fileInput = document.getElementById("file-upload");
      const file = fileInput.files[0];
  
      if (!file) {
        alert("Veuillez sélectionner un fichier !");
        return;
      }
  
      const formData = new FormData();
      formData.append("file", file);
  
      fetch("/php/upload_file.php", {
        method: "POST",
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Fichier téléchargé avec succès !");
        } else {
          alert("Erreur lors du téléchargement du fichier.");
        }
      })
      .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur de téléchargement. Essayez à nouveau.");
      });
    });
  });
  