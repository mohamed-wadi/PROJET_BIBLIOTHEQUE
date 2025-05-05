function validateCodeInput(generatedCode) {
    var codeInput = document.getElementById('validationServer03');
    var feedback = document.getElementById('validationServer03Feedback');
    var submitButton = document.querySelector('[name="CHECK"]');

    var enteredCode = codeInput.value;

    if (enteredCode === generatedCode) {
        codeInput.classList.remove('is-invalid');
        codeInput.classList.add('is-valid');
        feedback.innerText = 'Code verification valide.';
        submitButton.removeAttribute('disabled');
    } else {
        codeInput.classList.remove('is-valid');
        codeInput.classList.add('is-invalid');
        feedback.innerText = 'Code verification non valide.';
        submitButton.setAttribute('disabled', 'disabled');
    }
}