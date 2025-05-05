<?php
include("verification.php");

$message = '';
$test_ajout = -1;

// Vérification des informations de session
if (isset($_SESSION['id_client'])) {
    $nom = $_SESSION['nom_client'];
    $prenom = $_SESSION['prenom_client'];
    $role = $_SESSION['role'];
    $valid = 1;

    if ($role != "admin") {
        header("Location: 404.html");
    }
} else {
    header("Location: login.php");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['Othor_Add'])) {

    $nom_auteur = mysqli_real_escape_string($connexion, $_POST['nom_auteur']);
    $prenom_auteur = mysqli_real_escape_string($connexion, $_POST['prenom_auteur']);

    // Vérifier si l'auteur existe déjà
    $query_verification = "SELECT * FROM auteur WHERE nom_auteur = '$nom_auteur' AND prenom_auteur= '$prenom_auteur'";
    $result_verification = mysqli_query($connexion, $query_verification);

    if ($result_verification && mysqli_num_rows($result_verification) > 0) {
        $test_ajout = 0;
        $message = "This author already exists in the database.";
    } else {
        while (true) {
            $id_auteur = rand(10000000, 99999999);
            $query_check_ID = "SELECT * FROM auteur WHERE id_auteur = ?";
            $stmt = mysqli_prepare($connexion, $query_check_ID);
            mysqli_stmt_bind_param($stmt, "s", $id_auteur);
            mysqli_stmt_execute($stmt);
            $result_check_ID = mysqli_stmt_get_result($stmt);
            if (mysqli_num_rows($result_check_ID) == 0) {
                break;
            }
        }
        $query_ajouter_auteur = "INSERT INTO auteur (nom_auteur,prenom_auteur,id_auteur) VALUES ('$nom_auteur','$prenom_auteur','$id_auteur')";
        $result_ajouter_auteur = mysqli_query($connexion, $query_ajouter_auteur);
        if ($result_ajouter_auteur) {
            $test_ajout = 1;
            $message = "Author added successfully.";
        } else {
            $test_ajout = 0;
            $message = "Error adding data : " . mysqli_error($connexion);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<!-- molla/login.html  22 Nov 2019 10:04:03 GMT -->

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
                        <li class="breadcrumb-item active">Auteur Management</li>
                        <li class="breadcrumb-item active" aria-current="page">Add Auteur</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="true">Add Author</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="signin" role="tabpanel" aria-labelledby="signin-tab">
                                        <form action="Othor-Add.php" method="POST">
                                            <div class="form-group">
                                                <label for="prenom_auteur">First Name*</label>
                                                <input type="text" class="form-control" id="prenom_auteur" name="prenom_auteur" required>
                                            </div><!-- End .form-group -->

                                            <div class="form-group">
                                                <label for="nom_auteur">Last Name *</label>
                                                <input type="text" class="form-control" id="nom_auteur" name="nom_auteur" required>
                                            </div><!-- End .form-group -->


                                            <div class="form-footer">
                                                <button type="submit" class="btn btn-outline-primary-2" name="Othor_Add">
                                                    <span>ADD</span>
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
                                        <?php } else if ($test_ajout == 0) { ?>

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
                                        <?php } ?>

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