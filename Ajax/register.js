document.addEventListener("DOMContentLoaded", function () {
    var registerForm = document.getElementById('register-form');

    registerForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Empêcher la soumission du formulaire par défaut

        var formData = new FormData(registerForm); // Obtenir les données du formulaire

        fetch('register_fonction.php', {
            method: 'POST',
            body: formData // Envoyer les données du formulaire
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Redirection vers la page de connexion si l'inscription est réussie
                    window.location.href = '../index.php';
                } else {
                    // Affichage de l'erreur dans une alerte
                    alert('Erreur : ' + data.message);
                }
            })
            .catch(error => {
                console.error('Erreur lors de la requête AJAX : ', error);
                // Affichage de l'erreur dans une alerte
                alert('Une erreur s\'est produite lors du traitement de votre demande. Veuillez réessayer.');
            });
    });
});
