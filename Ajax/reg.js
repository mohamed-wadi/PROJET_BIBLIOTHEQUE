// Déclaration de la variable globale code_verification
var code_verification;

document.addEventListener("DOMContentLoaded", function () {
    // Sélection du formulaire et des boutons "Valider" et "Verify email"
    var registerForm = document.getElementById('register-form');
    var validButton = document.getElementById('validButton');

    // Sélection de tous les champs obligatoires
    var requiredInputs = registerForm.querySelectorAll('[required]');
    var phoneInput = document.querySelector('input[name="phone"]');
    var emailInput = document.getElementById('Email');

    // Sélection du div contenant le bouton "SIGN UP"
    var registerDiv = document.getElementById('register');

    // Masquer le bouton "SIGN UP" au chargement de la page
    registerDiv.style.display = 'none';

    // Fonction pour vérifier si un champ est une adresse email valide
    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

    // Fonction pour vérifier si un champ est un numéro de téléphone valide
    function isValidPhoneNumber(phone) {
        return /^\d{10}$/.test(phone);
    }

    // Fonction pour vérifier la validité de tous les champs du formulaire
    function checkFormValidity() {
        var allFilled = true;
        requiredInputs.forEach(function (input) {
            if (!input.value.trim()) {
                allFilled = false;
            }
        });

        // Vérifier la validité du numéro de téléphone
        if (!isValidPhoneNumber(phoneInput.value)) {
            phoneInput.classList.add('is-invalid');
            allFilled = false;
        } else {
            phoneInput.classList.remove('is-invalid');
        }

        // Vérifier la validité de l'email
        if (!isValidEmail(emailInput.value)) {
            emailInput.classList.add('is-invalid');
            allFilled = false;
        } else {
            emailInput.classList.remove('is-invalid');
        }

        // Activer le bouton "Valider" si tous les champs sont remplis et valides
        if (allFilled) {
            validButton.removeAttribute('disabled');
        } else {
            validButton.setAttribute('disabled', 'disabled');
        }
    }

    // Ajouter un écouteur d'événements de saisie pour chaque champ
    requiredInputs.forEach(function (input) {
        input.addEventListener('input', checkFormValidity);
    });

    // Vérifier le formulaire lors du chargement de la page
    checkFormValidity();

    // Ajouter un écouteur d'événements de clic sur le bouton "Valider"
    validButton.addEventListener('click', handleValidButtonClick);

    // Fonction pour gérer le clic sur le bouton "Valider"
    function handleValidButtonClick() {
        var email = emailInput.value.trim();
        if (isValidEmail(email)) {
            checkEmailExists(email);
        } else {
            emailInput.classList.add('is-invalid');
        }
    }

    // Fonction AJAX pour vérifier si l'email est déjà dans la base de données
    function checkEmailExists(email) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'test_clien_db.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            if (xhr.status >= 200 && xhr.status < 300) {
                var response = JSON.parse(xhr.responseText);
                if (response.error) {
                    // Afficher un message d'erreur
                    emailInput.classList.add('is-invalid');
                    document.getElementById('error-email').innerText = "The customer is already in the database.";
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
            codeInput.classList.remove('is-invalid');
            codeInput.classList.add('is-valid');
            feedback.innerText = 'Valid verification code.';
            submitButton.removeAttribute('disabled');
            // Masquer le modal
            // $('#verification-modal').modal('hide');
            // Afficher le bouton "SIGN UP"
            document.getElementById('register').style.display = 'block';
            // Masquer le bouton "Valid"
            document.getElementById('validDiv').style.display = 'none';

            var signUpButton = document.getElementById('register-button');
            var submitButton = document.getElementById('CHECK');

            // Ajouter un écouteur d'événements de clic sur le bouton "CHECK"
            submitButton.addEventListener('click', function () {
                // Vérifier si le bouton "CHECK" est désactivé
                if (!submitButton.disabled) {
                    // Déclencher un clic sur le bouton "SIGN UP"
                    signUpButton.click();
                }
            });
        } else {
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
