
<?php

$message = "";

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer/src/Exception.php';
require '../PHPMailer/src/PHPMailer.php';
require '../PHPMailer/src/SMTP.php';

function sendEmail($recipientEmail, $subject, $body, $verificationCode) {
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'shmbib931@gmail.com';
        $mail->Password   = 'yperaulstbjbumjr'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom('shmbib931@gmail.com', 'SHM');
        $mail->addAddress($recipientEmail);

        // Attach the logo image
        $mail->AddEmbeddedImage(dirname(__FILE__) . '/../image/logo.png', 'logo');

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = 'Enter this code for verifying your email: ' . $verificationCode;

        $mail->send();
        $message = "Message has been sent";
    } catch (Exception $e) {
        $message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
    return $message;
}

// $code_verification = rand(100000, 999999);

// $emailSubject = 'Verification Email for Your Account';
// $emailBody = '
// <html>
// <head>
//     <meta charset="UTF-8">
//     <style>
//         body {
            
//             margin: 0;
//             padding: 0;
//             background-color: #F3F0CA;
//         }

//         .container {
//             max-width: 600px;
//             margin: 0 auto;
//             text-align: center;
//             padding: 20px;
//         }

//         img {
//             max-width: 100%;
//             height: auto;
//             margin-bottom: 20px;
//         }

//         h2 {
//             color: #161A30;
//             font-size: 24px;
//             margin-bottom: 10px;
//         }

//         p {
//             color: #161A30;
//             margin-bottom: 15px;
//         }

//         .code {
//             background-color: #161A30;
//             border: none;
//             color: white;
//             padding: 15px 32px;
//             font-size: 30px;
//             cursor: pointer;
//             display: inline-block;
//             margin-top: 20px;
//         }

//         a {
//             color: #161A30;
//             text-decoration: none;
//         }

//         .large-text {
//             font-size: 150%;
//         }
//     </style>
// </head>

// <body>
//     <div class="container">
//         <img src="cid:logo" alt="logo">
//         <h2>Verify Your Email Address</h2>
//         <p>Thank you for registering with us. Please use the following code to verify your email address:</p>
//         <p class="large-text">Verification Code</p>
//         <p class="code">'.$code_verification.'</p>
//         <p>If you did not register or did not request this verification, please ignore this email.</p>
//     </div>
// </body>
// </html>

// ';

// $recipientEmail = "logogenius9@gmail.com";
// $result = sendEmail($recipientEmail, $emailSubject, $emailBody, $code_verification);
// echo $result;
