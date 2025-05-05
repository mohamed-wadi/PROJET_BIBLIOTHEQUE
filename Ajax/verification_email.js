// Déclaration de la variable globale code_verification
var code_verification;

document.addEventListener("DOMContentLoaded", function () {
    var emailInput = document.getElementById('email');
    var validButton = document.getElementById('validButton');
    var verificationForm = document.getElementById('verification_email'); // Sélection du formulaire

    // Définition de requiredInputs
    var requiredInputs = [emailInput];

    // Masquer le bouton "SEND CODE" au chargement de la page
    validButton.disabled = true;

    // Fonction pour vérifier si un champ est une adresse email valide
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Fonction pour vérifier la validité de tous les champs du formulaire
    function checkFormValidity() {
        var allFilled = true;
        requiredInputs.forEach(function (input) {
            if (!input.value.trim()) {
                allFilled = false;
            }
        });
        // Vérifier la validité de l'email
        if (!isValidEmail(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            allFilled = false;
        } else {
            emailInput.classList.remove('is-invalid');
        }

        // Activer le bouton "SEND CODE" si tous les champs sont remplis et valides
        if (allFilled) {
            validButton.disabled = false;
        } else {
            validButton.disabled = true;
        }
    }

    // Ajouter un écouteur d'événements de saisie pour chaque champ
    requiredInputs.forEach(function (input) {
        input.addEventListener('input', checkFormValidity);
    });

    // Vérifier le formulaire lors du chargement de la page
    checkFormValidity();

    // Ajouter un écouteur d'événements de clic sur le bouton "SEND CODE"
    validButton.addEventListener('click', handleValidButtonClick);

    // Fonction pour gérer le clic sur le bouton "SEND CODE"
    function handleValidButtonClick() {
        var email = emailInput.value.trim();
        checkEmailExists(email); // Vérifiez d'abord si l'email existe dans la base de données
    }

    // Ajout d'un écouteur d'événements de soumission du formulaire
    verificationForm.addEventListener('submit', function (event) {
        event.preventDefault(); // Empêche la soumission du formulaire par défaut
        var code = document.getElementById('validationEmail').value.trim();
        // Vérifiez le code de vérification ici
    });

    // Fonction AJAX pour vérifier si l'email est déjà dans la base de données
    function checkEmailExists(email) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'test_clien_db.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                var response = JSON.parse(xhr.responseText);
                if (!response.error) {
                    // Afficher un message d'erreur
                    emailInput.classList.add('is-invalid');
                    document.getElementById('error-email').innerText = "The customer is not found in the database.";
                } else {
                    // Générer et envoyer le code de vérification par e-mail
                    generateAndSendVerificationCode(email);
                }
            } else {
                console.error('Error during AJAX request : ', xhr.statusText);
            }
        };
        xhr.onerror = function () {
            console.error('Error during AJAX request.');
        };
        xhr.send('Email=' + encodeURIComponent(email));
    }

    // Fonction pour générer et envoyer le code de vérification par e-mail
    function generateAndSendVerificationCode(email) {
        code_verification = Math.floor(100000 + Math.random() * 900000);

        fetch('generateVerificationCodeAndEmail.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'Email=' + encodeURIComponent(email) + '&code_verification=' + code_verification
        })
            .then(response => {
                if (response.ok) {
                    return response.text(); // Récupérer le résultat de l'envoi de l'e-mail
                } else {
                    throw new Error('Error during AJAX request');
                }
            })
            .then(result => {
                showModal(email);
            })
            .catch(error => console.error('Error during AJAX request : ', error));
    }

    // Fonction pour afficher la modal de vérification d'email avec le code généré
    function showModal(email) {
        var modal = new bootstrap.Modal(document.getElementById('verification-modal'));
        document.getElementById('email_client').innerText = email;
        modal.show();
    }
});



// **********************MODAL**********************

// Associer la fonction validateCodeInput à l'événement input du champ de code
document.addEventListener('DOMContentLoaded', function () {
    // Associer la fonction validateCodeInput à l'événement input du champ de code
    $('#validationEmail').on('input', validateCodeInput);
});

// Fonction pour valider le champ de code de vérification
function validateCodeInput() {
    var codeInput = document.getElementById('validationEmail');
    var infeedback = document.getElementById('invalidationEmailFeedback');
    var feedback = document.getElementById('validationEmailFeedback');
    var submitButton = document.getElementById('CHECK');

    var enteredCode = codeInput.value.trim(); // Supprimer les espaces blancs avant et après le code entré

    // Vérifier si le code saisi par l'utilisateur est un nombre entier
    if (/^\d+$/.test(enteredCode)) {
        // Vérifier si le code saisi correspond au code de vérification
        if (enteredCode == code_verification) {
            var ToPasswoardDiv = document.getElementById('ToPasswoardDiv');
            var ToPasswoardButton = document.getElementById('ToPasswoardButton');
            var validDiv = document.getElementById('validDiv');
            codeInput.classList.remove('is-invalid');
            codeInput.classList.add('is-valid');
            feedback.innerText = 'Valid verification code.';
            submitButton.removeAttribute('disabled');
                            
            ToPasswoardDiv.style.display = 'block';
            validDiv.style.display = 'none';
            ToPasswoardButton.removeAttribute('disabled');
        }else {
            codeInput.classList.remove('is-valid');
            codeInput.classList.add('is-invalid');
            infeedback.innerText = 'Invalid verification code.';
            submitButton.setAttribute('disabled', 'disabled');
        }
    } else {
        // Le code saisi n'est pas un nombre entier
        codeInput.classList.remove('is-valid');
        codeInput.classList.add('is-invalid');
        infeedback.innerText = 'Please enter a valid verification code.';
        submitButton.setAttribute('disabled', 'disabled');
    }
}
