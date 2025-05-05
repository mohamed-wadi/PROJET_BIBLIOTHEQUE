<?php
include('connexion-DB.php');
session_start();
$test_erreur = 0;
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $_SESSION["email"] = $_GET["email"];
    $Email = $_SESSION["email"];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['UPDATE'])) {
    $password = $_POST['password'];
    $Email = $_SESSION["email"];

    // Verify the old password before updating
    $query_check_user = "SELECT * FROM client WHERE Email = ?";
    $stmt_check_user = mysqli_prepare($connexion, $query_check_user);
    mysqli_stmt_bind_param($stmt_check_user, "s", $Email);
    mysqli_stmt_execute($stmt_check_user);
    $result_check_user = mysqli_stmt_get_result($stmt_check_user);

    if ($row = mysqli_fetch_assoc($result_check_user)) {
        // Update the password in the database
        $query_update_password = "UPDATE client SET MDP = ? WHERE Email = ?";
        $stmt_update_password = mysqli_prepare($connexion, $query_update_password);
        mysqli_stmt_bind_param($stmt_update_password, "ss", $password, $Email);
        $result_update_password = mysqli_stmt_execute($stmt_update_password);

        if ($result_update_password) {
            header("Location: login.php");
        } else {
            // Error updating password
            $test_erreur = 1;
            $message = "Error updating password.";
        }
    } else {
        // User does not exist
        $test_erreur = 1;
        $message = "No account associated with this email. Please register.";
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../header/head.html' ?>
</head>

<body>

    <div class="page-wrapper">

        <main class="main">

            <div class=" bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#" role="tab" aria-controls="signin-2" aria-selected="false">Reset password</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">
                                    <form action="password.php" method="POST">
                                        <div class="form-group">
                                            <label for="password">Password *</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter your new password" required>
                                        </div><!-- End .form-group -->
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2" name="UPDATE" id="sub">UPDATE</button>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    <?php if ($test_erreur == 1) { ?>
                                        <div class="form-footer">
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
                                        </div><!-- End .form-footer -->
                                    <?php } ?>
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