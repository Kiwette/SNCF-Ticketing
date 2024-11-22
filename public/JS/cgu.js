// Fonction pour afficher un message d'alerte de bienvenue
function showAlert() {
    alert("Bienvenue sur la page des CGU de SNCF Ticketing!");
}

// Fonction pour récupérer les CGU depuis l'API
function fetchCGU() {
    const cguContent = document.getElementById('cgu-content');  // Cibler l'élément HTML où afficher les CGU

    // Afficher un message pendant le chargement des CGU
    cguContent.innerHTML = "<p>Chargement des conditions d'utilisation...</p>";

    // Effectuer une requête pour récupérer les CGU via l'API
    fetch('/api/cgu')  // L'URL de ton API PHP
        .then(response => response.json())  // Convertir la réponse en JSON
        .then(data => {
            // Une fois les données récupérées, afficher les CGU
            cguContent.innerHTML = `
                <h3 style="color: #82BE00;">1. Introduction</h3>
                <p>${data.introduction}</p>
                
                <h3 style="color: #82BE00;">2. Accès à l'application</h3>
                <p>${data.acces}</p>

                <h3 style="color: #82BE00;">3. Utilisation des Services</h3>
                <p>${data.services}</p>

                <h3 style="color: #82BE00;">4. Propriété Intellectuelle</h3>
                <p>${data.propriete}</p>

                <h3 style="color: #82BE00;">5. Responsabilités</h3>
                <p>${data.responsabilites}</p>

                <h3 style="color: #82BE00;">6. Modifications des Conditions</h3>
                <p>${data.modifications}</p>

                <h3 style="color: #82BE00;">7. Contact</h3>
                <p>${data.contact}</p>
            `;
        })
        .catch(error => {
            // Si une erreur se produit, afficher un message d'erreur
            cguContent.innerHTML = "<p>Erreur lors du chargement des CGU. Veuillez réessayer plus tard.</p>";
            console.error('Erreur lors de la récupération des CGU:', error);  // Loguer l'erreur dans la console pour le débogage
        });
}

// Exécuter la fonction lors du chargement de la page
window.onload = function() {
    showAlert();   // Afficher l'alerte de bienvenue
    fetchCGU();    // Récupérer et afficher les CGU via l'API
};
