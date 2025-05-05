<?php

$test_erreur = 0;
$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Email = isset($_POST['email']) ? $_POST['email'] : null;
    $code_verification = isset($_POST['code_verification']) ? $_POST['code_verification'] : null;
    $page = isset($_POST['page']) ? $_POST['page'] : null;
}

// $Email = isset($_COOKIE['Email']) ? $_COOKIE['Email'] : '';
// $code_verification = isset($_COOKIE['code_verification']) ? $_COOKIE['code_verification'] : '';
// $page = isset($_COOKIE['page']) ? $_COOKIE['page'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['CHECK'])) {
    $code = $_POST['code'];
    if ($page == 'register') {
        $nom_client = isset($_COOKIE['nom_client']) ? $_COOKIE['nom_client'] : '';
        $prenom_client = isset($_COOKIE['prenom_client']) ? $_COOKIE['prenom_client'] : '';
        $date_naissance = isset($_COOKIE['date_naissance']) ? $_COOKIE['date_naissance'] : '';
        $genre = isset($_COOKIE['genre']) ? $_COOKIE['genre'] : '';
        $country = isset($_COOKIE['country']) ? $_COOKIE['country'] : '';
        $Email = isset($_COOKIE['Email']) ? $_COOKIE['Email'] : '';
        $phone = isset($_COOKIE['phone']) ? $_COOKIE['phone'] : '';
        $MDP = isset($_COOKIE['MDP']) ? $_COOKIE['MDP'] : '';
        $Date_inscription = isset($_COOKIE['Date_inscription']) ? $_COOKIE['Date_inscription'] : '';
        $role = isset($_COOKIE['role']) ? $_COOKIE['role'] : '';

        // Générez l'ID unique
        while (true) {
            $id_client = rand(10000000, 99999999);
            $query_check_ID = "SELECT * FROM client WHERE id_client = '$id_client'";
            $result_check_ID = mysqli_query($connexion, $query_check_ID);

            if (mysqli_num_rows($result_check_ID) === 0) {
                // L'ID est unique, sortir de la boucle
                break;
            }
        }

        // Requête préparée pour l'insertion
        $query_insert_user = "INSERT INTO client (nom_client,prenom_client,date_naissance,genre,country,phone,Email,MDP,Date_inscription,id_client,role) VALUES ('$nom_client','$prenom_client','$date_naissance','$genre','$country','$phone','$Email','$MDP','$Date_inscription','$id_client','$role')";

        $execute = mysqli_query($connexion, $query_insert_user);

        if ($execute) {
            session_unset();
            $_SESSION['id_client'] = $id_client;
            $_SESSION['nom_client'] = $nom_client;
            $_SESSION['prenom_client'] = $prenom_client;
            $_SESSION['role'] = $role;

            // Vérifier si l'opération a réussi
            header("Location: login.php");
            exit();
        } else {
            // Erreur lors de l'insertion dans la base de données.
            $test_erreur = 1;
            $message = "Error inserting into the database.";
        }
    } elseif ($page == 'verificationemail') {
        $email = urlencode($Email);
        $redirectUrl = "password.php?email={$email}";
        header("Location: $redirectUrl");
        exit();
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <?php include '../header/head.html'; ?>

    <script src="../Admin_Style/generateVerificationCodeAndEmailBody.js"></script>
    <script>
        var generatedCode = "code verification";

        document.addEventListener('DOMContentLoaded', function() {
            // Associer la fonction validateCodeInput à l'événement input du champ de code
            $('#validationServer03').on('input', function() {
                validateCodeInput(generatedCode);
            });
        });

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
    </script>
</head>

<body>

    <div class="page-wrapper">

        <main class="main">

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                                    <form action="verification_code.php" method="POST">
                                        <div class=" text-center" width="100%">
                                            <div class="card-body">
                                                <h5 class="card-title">Code Verification</h5>
                                                <p class="card-text">Entrez le code qui vous a été envoyé dans cet email</p>
                                                <p class="card-text">
                                                    <?php echo $Email; ?>
                                                </p>

                                            </div>
                                        </div>

                                        <div>
                                            <input type="text" class="form-control" id="validationServer03" aria-describedby="validationServer03Feedback" name="code" placeholder="Entrez le code de vérification" oninput="validateCodeInput()" maxlength="6" required>
                                            <div id="validationServer03Feedback" class="invalid-feedback">
                                                Code verification non valide.
                                            </div>
                                            <div class="valid-feedback">
                                                Code verification valide
                                            </div>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2" name='CHECK' disabled>CHECK</button>
                                        </div>
                                    </form>
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->

    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
</body>

</html>