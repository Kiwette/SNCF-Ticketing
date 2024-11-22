// Fonction d'alerte au chargement de la page
function showAlert() {
    alert("Bienvenue sur votre page de création de profil, SNCF Ticketing!");
}

// Appel de la fonction showAlert au chargement de la page
window.onload = function () {
    showAlert();
};

// Fonction de validation du formulaire
function validateForm() {
    // Récupérer les valeurs des champs
    const nom = document.getElementById('nom').value;
    const prenom = document.getElementById('prenom').value;
    const cp = document.getElementById('cp').value;
    const email = document.getElementById('email').value;
    const mdp = document.getElementById('mdp').value;
    const mdp2 = document.getElementById('mdp2').value;
    const terms = document.getElementById('terms').checked;

    // Validation des champs
    if (nom === "" || prenom === "" || cp === "" || email === "" || mdp === "" || mdp2 === "") {
        alert("Tous les champs doivent être remplis.");
        return false;
    }

    // Vérification du format de l'email
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        alert("Veuillez entrer une adresse email valide.");
        return false;
    }

    // Vérification que les mots de passe correspondent
    if (mdp !== mdp2) {
        alert("Les mots de passe ne correspondent pas.");
        return false;
    }

    // Vérification que la case des conditions est cochée
    if (!terms) {
        alert("Vous devez accepter les conditions.");
        return false;
    }

    // Si toutes les validations sont passées
    alert("Votre compte a été créé avec succès !");
    return true;
}

// Fonction pour afficher/masquer les mots de passe
function togglePassword() {
    const mdp = document.getElementById('mdp');
    const mdp2 = document.getElementById('mdp2');
    const toggleIcon = document.getElementById('togglePassword');

    if (mdp.type === "password" && mdp2.type === "password") {
        mdp.type = "text";
        mdp2.type = "text";
        toggleIcon.classList.add('fa-eye-slash');
        toggleIcon.classList.remove('fa-eye');
    } else {
        mdp.type = "password";
        mdp2.type = "password";
        toggleIcon.classList.remove('fa-eye-slash');
        toggleIcon.classList.add('fa-eye');
    }
}
