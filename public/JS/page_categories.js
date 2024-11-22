document.addEventListener("DOMContentLoaded", function() {
    const categoryForm = document.getElementById("category-form");
  
    categoryForm.addEventListener("submit", function(event) {
      event.preventDefault();
  
      const categoryName = document.getElementById("category-name").value;
  
      if (!categoryName) {
        alert("Veuillez entrer un nom de catégorie !");
        return;
      }
  
      const formData = new FormData();
      formData.append("category_name", categoryName);
  
      fetch("/php/add_category.php", {
        method: "POST",
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          alert("Catégorie ajoutée avec succès !");
          // Optionnel: Recharger la liste des catégories
          location.reload();
        } else {
          alert("Erreur lors de l'ajout de la catégorie.");
        }
      })
      .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur lors de l'ajout. Essayez à nouveau.");
      });
    });
  });
  