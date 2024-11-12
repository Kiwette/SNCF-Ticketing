<?php
// Démarrer la session pour vérifier si l'utilisateur est connecté
session_start();

// Vérification si l'utilisateur est administrateur
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'Administrateur') {
    // Si l'utilisateur n'est pas un administrateur, redirigez-le vers la page de connexion
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Administrateur - SNCF Ticketing</title>
    <link rel="stylesheet" href="/CSS/admin.css"> <!-- Si vous avez un fichier CSS pour la page admin -->
<body>
    <section>
        <!-- Header -->
        <header class="header">
            <img class="logo_sncf" src="/Images/logo.news.png" alt="logo_sncf"/>
            <div class="presentation">
                <h1 class="titre_principal">SNCF TICKETING - Page Administrateur</h1>
            </div>
            <nav class="nav">
                <li><a href="#">Gestion des utilisateurs</a></li>
                <li><a href="/logout.php">Se déconnecter</a></li>
            </nav>
        </header>

        <!-- Section pour afficher la liste des utilisateurs -->
        <div class="user-list-section">
            <h2>Liste des utilisateurs</h2>
            <ul id="userList">
    <!-- Exemple dynamique pour un utilisateur -->
    <li>
        Nom: John Doe, Email: john.doe@example.com, Rôle: Utilisateur
        <button onclick="changeUserRole(1, 'admin')">Passer Administrateur</button>
        <button onclick="changeUserRole(1, 'user')">Passer Utilisateur</button>
    </li>
</ul>

        </div>

        <!-- Footer -->
        <footer class="footer">
            <img class="logo_sncf2" src="/Images/logo-removebg-preview.png" alt="logo_sncf2"/>
            <div class="contenu_footer">
                <h3>SNCF Ticketing |
                    <a href="/version.html" class="footer-link">Version 1.1</a> |
                    <a href="/cgu.html" class="footer-link">CGU</a> |
                    <a href="/mentions-legales.html" class="footer-link">Mentions légales</a> |
                    <a href="/page_contacts.html" class="footer-link">Contactez-nous</a>
                    e-SNCF ©2024
                </h3>
            </div>
        </footer>
    </section>

    <script>
        // Fonction pour récupérer la liste des utilisateurs via AJAX
        async function fetchUsers() {
    try {
        const response = await fetch('/path_to_your_php_page_that_returns_users.php'); // Exemple : /api/get_users.php
        const users = await response.json();

        // Sélectionner le conteneur où la liste des utilisateurs sera affichée
        const userList = document.getElementById('userList');

        // Réinitialiser la liste pour éviter les doublons
        userList.innerHTML = '';

        // Ajouter chaque utilisateur à la liste HTML
        users.forEach(user => {
            const listItem = document.createElement('li');
            listItem.textContent = `Nom: ${user.nom}, Email: ${user.email}, Rôle: ${user.role}`;
            userList.appendChild(listItem);
        });
    } catch (error) {
        console.error('Erreur lors de la récupération des utilisateurs :', error);
    }
    }

    function changeUserRole(userId, newRole) {
    fetch(`/api/users/${userId}/role`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ role: newRole })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message); // Afficher un message de confirmation
        fetchUsers(); // Rafraîchir la liste des utilisateurs
    })
    .catch(error => console.error('Erreur:', error));
}

        // Appeler la fonction pour charger les utilisateurs quand la page est prête
        window.onload = fetchUsers;
    </script>
</body>
</html>
