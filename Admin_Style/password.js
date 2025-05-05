var myInput = document.getElementById('password');
var letter = document.getElementById('letter');
var capital = document.getElementById('capital');
var number = document.getElementById('number');
var length = document.getElementById('length');
var submitButton = document.getElementById('sub');

myInput.onfocus = function () {
    document.getElementById("error").style.display = "block"
}

myInput.onblur = function () {
    document.getElementById("error").style.display = "none"
}

myInput.onkeyup = function () {
    var lowerCaseLetters = /[a-z]/g
    var upperCaseLetters = /[A-Z]/g
    var numbers = /[0-9]/g

    letter.classList.toggle('valid__message', myInput.value.match(lowerCaseLetters));
    letter.classList.toggle('error__message', !myInput.value.match(lowerCaseLetters));

    capital.classList.toggle('valid__message', myInput.value.match(upperCaseLetters));
    capital.classList.toggle('error__message', !myInput.value.match(upperCaseLetters));

    number.classList.toggle('valid__message', myInput.value.match(numbers));
    number.classList.toggle('error__message', !myInput.value.match(numbers));

    length.classList.toggle('valid__message', myInput.value.length >= 8);
    length.classList.toggle('error__message', myInput.value.length < 8);

    // Vérifier toutes les conditions avant d'afficher le bouton
    var isValidPassword = myInput.value.match(lowerCaseLetters) &&
        myInput.value.match(upperCaseLetters) &&
        myInput.value.match(numbers) &&
        myInput.value.length >= 8;

    // Appliquer les classes is-valid ou is-invalid au champ de mot de passe
    myInput.classList.remove('is-valid', 'is-invalid');
    myInput.classList.add(isValidPassword ? 'is-valid' : 'is-invalid');

    // Activer ou désactiver le bouton de soumission en fonction de la validité du mot de passe
    submitButton.disabled = !isValidPassword;
}
