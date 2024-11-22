document.addEventListener('DOMContentLoaded', function () {
    // Fonction de validation du formulaire
    function validateForm() {
        const nom = document.getElementById('nom')?.value || "";
        const email = document.getElementById('email')?.value || "";
        const demande = document.getElementById('demande')?.value || "";

        if (nom.trim() === "" || email.trim() === "" || demande.trim() === "") {
            alert("Tous les champs doivent être remplis avant l'envoi.");
            return false;
        }

        alert("Votre demande a été envoyée avec succès, nous vous répondrons dans les plus brefs délais !");
        return true;
    }

    // Gestion du compteur de caractères
    const demandeField = document.getElementById('demande');
    const maxChars = 400;

    if (demandeField) {
        // Création et insertion du compteur
        const counter = document.createElement('div');
        counter.id = 'charCounter';
        counter.style.marginTop = '5px';
        counter.style.fontSize = '0.9em';
        counter.style.color = 'black';
        counter.innerHTML = `0/${maxChars}`;
        demandeField.parentNode.insertBefore(counter, demandeField.nextSibling);

        // Mise à jour du compteur lors de la saisie
        demandeField.addEventListener('input', function () {
            const charCount = demandeField.value.length;
            counter.innerHTML = `${charCount}/${maxChars}`;
            counter.style.color = charCount > maxChars ? 'red' : 'black';
        });
    }

    // Attacher l'événement de validation au formulaire
    const form = document.querySelector('form'); // Assurez-vous que votre formulaire est entouré d'une balise <form>
    if (form) {
        form.addEventListener('submit', function (event) {
            if (!validateForm()) {
                event.preventDefault(); // Empêche l'envoi si la validation échoue
            }
        });
    }
});
