// Exemple de fonction pour changer le rôle d'un utilisateur
function changeUserRole(userId, newRole) {
    // Ajouter le jeton CSRF à la requête
    fetch('/api/users/role', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            role: newRole,
            userId: userId,
            csrf_token: '<?php echo $_SESSION["csrf_token"]; ?>' // Injecter le jeton CSRF PHP dans la requête
        })
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        // Vous pouvez également mettre à jour l'affichage du rôle dans la page
    })
    .catch(error => {
        console.error('Erreur:', error);
    });
}
