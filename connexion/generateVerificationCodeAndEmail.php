<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Vérification que les données ont été envoyées
    if (isset($_POST['Email']) && isset($_POST['code_verification'])) {
        $Email = $_POST['Email'];
        $code_verification = $_POST['code_verification'];

        // Assurez-vous que la fonction sendEmail() est définie dans email.php
        require 'email.php';

        $emailSubject = 'Verification Email for Your Account';

        $emailBody = '
            <html>
            <head>
                <meta charset="UTF-8">
                <style>
                body {
                    margin: 0;
                    padding: 0;
                    background-color: #F3F0CA;
                }
        
                .container {
                    max-width: 600px;
                    margin: 0 auto;
                    text-align: center;
                    padding: 20px;
                }
        
                img {
                    max-width: 100%;
                    height: auto;
                    margin-bottom: 20px;
                }
        
                h2 {
                    color: #161A30;
                    font-size: 24px;
                    margin-bottom: 10px;
                }
        
                p {
                    color: #161A30;
                    margin-bottom: 15px;
                }
        
                .code {
                    background-color: #161A30;
                    border: none;
                    color: white;
                    padding: 15px 32px;
                    font-size: 30px;
                    cursor: pointer;
                    display: inline-block;
                    margin-top: 20px;
                }
        
                a {
                    color: #161A30;
                    text-decoration: none;
                }
        
                .large-text {
                    font-size: 150%;
                }
            </style>
            </head>
            <body>
                <div class="container">
                    <img src="cid:logo" alt="logo">
                    <h2>Verify Your Email Address</h2>
                    <p>Thank you for registering with us. Please use the following code to verify your email address:</p>
                    <p class="large-text">Verification Code</p>
                    <p class="code">' . $code_verification . '</p>
                    <p>If you did not register or did not request this verification, please ignore this email.</p>
                </div>
            </body>
            </html>
        ';

        // Envoyer l'e-mail
        $send = sendEmail($Email, $emailSubject, $emailBody, $code_verification);

        // Afficher le résultat de l'envoi de l'e-mail dans la réponse
        echo $send;
    } else {
        echo "erreur";
    }
}
