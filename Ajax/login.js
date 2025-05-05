document.getElementById('login-form').addEventListener('submit', function(event) {
    event.preventDefault();

    var formData = new FormData(this);

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'login_fonction.php', true);
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.error === "email") {
                document.getElementById('error-message-email').innerHTML = response.message;
                document.getElementById('validationServerEmail').classList.add('is-invalid');
            } else if (response.error === "password") {
                document.getElementById('error-message-password').innerHTML = response.message;
                document.getElementById('validationServerPassword').classList.add('is-invalid');
            } else {
                window.location.href = response.redirectUrl;
            }
        }
    };
    xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
    xhr.send(formData);
});
