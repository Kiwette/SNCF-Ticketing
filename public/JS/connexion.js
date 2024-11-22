function showAlert() {
    alert("Bienvenue sur votre page de connexion, SNCF Ticketing!");
}

window.onload = function() {
    showAlert();
};

document.addEventListener("DOMContentLoaded", function() {
    const loginForm = document.getElementById("login-form");
  
    loginForm.addEventListener("submit", function(event) {
      event.preventDefault();
      const email = document.getElementById("email").value;
      const password = document.getElementById("password").value;
      
      // Simple validation
      if (!email || !password) {
        alert("Veuillez remplir tous les champs !");
        return;
      }
  
      // Envoi des données au serveur via AJAX
      const formData = new FormData();
      formData.append("email", email);
      formData.append("password", password);
  
      fetch("/php/login.php", {
        method: "POST",
        body: formData,
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          window.location.href = "/page_admin.html";
        } else {
          alert("Identifiants incorrects !");
        }
      })
      .catch(error => {
        console.error("Erreur:", error);
        alert("Erreur de connexion. Essayez à nouveau.");
      });
    });
  });
  