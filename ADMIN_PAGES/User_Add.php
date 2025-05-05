<?php

include("verification.php");

$message = '';
$test_ajout = -1;

function generatePassword($length = 10) {
    // Caractères autorisés dans le mot de passe
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $password = '';

    // Choisissez au hasard un chiffre pour inclure dans le mot de passe
    $password .= $numbers[rand(0, strlen($numbers) - 1)];

    // Génération du reste du mot de passe
    for ($i = 1; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    // Mélangez les caractères pour un mot de passe plus aléatoire
    $password = str_shuffle($password);
    
    return $password;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['User_Add'])) {
    $nom_client = $_POST['nom_client'];
    $prenom_client = $_POST['prenom_client'];
    $date_naissance = $_POST['date_naissance'];
    $genre = $_POST['genre'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $Email = $_POST['Email'];
    $MDP = generatePassword(10);
    $role = $_POST['role'];

    // Vérifier si l'utilisateur existe déjà
    $query_verification = "SELECT * FROM client WHERE Email = ?";
    $stmt_verification = mysqli_prepare($connexion, $query_verification);
    mysqli_stmt_bind_param($stmt_verification, "s", $Email);
    mysqli_stmt_execute($stmt_verification);
    $result_verification = mysqli_stmt_get_result($stmt_verification);

    if ($result_verification && mysqli_num_rows($result_verification) > 0) {
        $message = "This customer already exists in the database.";
        $test_ajout = 0;
    } else {
        while (true) {
            $id = rand(10000000, 99999999);
            $query_check_ID = "SELECT * FROM client WHERE id_client = ?";
            $stmt = mysqli_prepare($connexion, $query_check_ID);
            mysqli_stmt_bind_param($stmt, "s", $id);
            mysqli_stmt_execute($stmt);
            $result_check_ID = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result_check_ID) == 0) {
                break;
            }
        }
        $query_ajouter_utilisateur = "INSERT INTO client (Email, MDP, nom_client, prenom_client, date_naissance, genre, country, phone, id_client, role) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt_ajouter_utilisateur = mysqli_prepare($connexion, $query_ajouter_utilisateur);
        mysqli_stmt_bind_param($stmt_ajouter_utilisateur, "ssssssssss", $Email, $MDP, $nom_client, $prenom_client, $date_naissance, $genre, $country, $phone, $id, $role);
        $result_ajouter_utilisateur = mysqli_stmt_execute($stmt_ajouter_utilisateur);

        if ($result_ajouter_utilisateur) {
            $message = "Client added successfully.";
            $test_ajout = 1;
        } else {
            $message = "Error adding data: " . mysqli_error($connexion);
            $test_ajout = 0;
        }
    }
}
mysqli_close($connexion);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include("../ADMIN_PAGES/head.html");
    include("../ADMIN_PAGES/script.html");
    ?>
    



</head>

<body>
    <div class="page-wrapper">
        <?php include("header_admin.php"); ?>

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index_admin.php">Home</a></li>
                        <li class="breadcrumb-item">User Management</li>
                        <li class="breadcrumb-item active" aria-current="page">Add User</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#" role="tab" aria-controls="signin-2" aria-selected="true">Add</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                        <form action="User_Add.php" method="POST">
                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>First Name *</label>
                                                        <input type="text" class="form-control" name="nom_client" required>
                                                    </div><!-- End .col-sm-6 -->
                                                    <div class="col-sm-6">
                                                        <label>Last Name *</label>
                                                        <input type="text" class="form-control" name="prenom_client" required>
                                                    </div><!-- End .col-sm-6 -->
                                                </div>
                                            </div><!-- End .row -->
                                            <div class="form-group">
                                                <label for="register-date-2">Date of Birth *</label>
                                                <input type="date" class="form-control" id="register-date-2" name="date_naissance" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="gender">Gender * :</label>
                                                <div class="form-check form-check-inline col-2">
                                                    <input class="form-check-input" type="radio" name="genre" id="inlineRadio1" value="woman">
                                                    <label class="form-check-label" for="inlineRadio1">Women</label>
                                                </div>

                                                <div class="form-check form-check-inline col-2">
                                                    <input class="form-check-input" type="radio" name="genre" id="inlineRadio2" value="man" checked>
                                                    <label class="form-check-label" for="inlineRadio2">Man</label>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label for="register-date-2">Country *</label>
                                                        <select class="form-control countrypicker " name="country"></select>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <label for="register-date-2">Number *</label>
                                                        <input type="tel" id="typePhone" class="form-control" name="phone" maxlength="9" required />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="phone">Email *</label>
                                                <input type="email" class="form-control" id="phone" name="Email" placeholder="Enter your email" required>
                                            </div><!-- End .form-group -->

                                            <!-- <div class="form-group">
                                                <label for="register-password-2">Password *</label>
                                                <input type="password" class="form-control" id="password" name="MDP" required>
                                            </div> -->
                                            <div class="form-group">
                                                <label for="Etat">Role *</label>
                                                <select id="pays" name="role" class="form-control">
                                                    <option value="client">Client</option>
                                                    <option value="admin">Admin</option>
                                                </select>
                                            </div><!-- End .form-group -->

                                            <div class="form-footer">
                                                <button type="submit" class="btn btn-outline-primary-2 sub" name="User_Add" id="sub">
                                                    <span>SIGN UP</span>
                                                    <i class="icon-long-arrow-right"></i>
                                                </button>
                                            </div><!-- End .form-footer -->
                                        </form>

                                        <?php if ($test_ajout == 1) { ?>
                                            <div class="info">
                                                <div class="info__icon">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 8.207-4 4a1 1 0 0 1-1.414 0l-2-2a1 1 0 0 1 1.414-1.414L9 10.586l3.293-3.293a1 1 0 0 1 1.414 1.414Z" />
                                                    </svg>
                                                </div>
                                                <div class="info__title">
                                                    <?php echo $message ?>
                                                </div>
                                            </div>
                                        <?php $test_ajout = -1;
                                        } else if ($test_ajout == 0) { ?>

                                            <div class="error">
                                                <div class="error__icon">
                                                    <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                    </svg>
                                                </div>
                                                <div class="error__title">
                                                    <?php echo $message ?>
                                                </div>

                                            </div>
                                        <?php $test_ajout = -1;
                                        } ?>


                                    </div><!-- .End .tab-pane -->
                                </div><!-- End .tab-content -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main><!-- End .main -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <?php include("menu_telephone_admin.php"); ?>

</body>

</html>