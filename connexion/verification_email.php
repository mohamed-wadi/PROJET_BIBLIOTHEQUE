<!DOCTYPE html>
<html lang="en">

<head>
    <?php include '../header/head.html'; ?>
</head>

<body>
    <div class="page-wrapper">
        <main class="main">
            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link" id="signin-tab-2" data-toggle="tab" href="#" role="tab" aria-controls="signin-2" aria-selected="false">Email Address Confirmation</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel" aria-labelledby="register-tab-2">

                                    <form action="password.php" action="GET">
                                        <div class="form-group">
                                            <label class="form-label">Your email address *</label>
                                            <div class="input-group has-validation">
                                                <input type="email" class="form-control" id="email" name="email" placeholder="Entre your number" value="test@example.com" required>
                                                <div id="error-email" class="invalid-feedback">The email is invalid.</div>
                                            </div>
                                        </div>

                                        <div class="form-footer" id="validDiv">
                                            <button type="button" class="btn btn-outline-primary-2" id="validButton" disabled>
                                                <span>Valide</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div>

                                        <div class="form-footer" id="ToPasswoardDiv" style="display: none;">
                                            <button type="submit" class="btn btn-outline-primary-2" name="ToPasswoardButton" id="ToPasswoardButton" disabled>
                                                <span>To Passwoard</span>
                                            </button>
                                        </div><!-- End .form-footer -->
                                    </form>
                                    
                                    <div class="modal" id="verification-modal" tabindex="-1" role="dialog" aria-labelledby="ModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content rounded-0">
                                                <div class="modal-body p-4 px-5">
                                                    <div class="main-content text-center">
                                                        <div class="text-center" width="100%">
                                                            <div class="card-body">
                                                                <h5 class="card-title">Code Verification</h5>
                                                                <p class="card-text">Entrez le code qui vous a été envoyé dans cet email</p>
                                                                <p class="card-text" id="email_client"></p>
                                                            </div>
                                                        </div>

                                                        <div>
                                                            <input type="text" class="form-control" id="validationEmail" aria-describedby="validationEmailFeedback" name="code" placeholder="Entrez le code de vérification" maxlength="6" required>
                                                            <div id="invalidationEmailFeedback" class="invalid-feedback"></div>
                                                            <div class="valid-feedback" id="validationEmailFeedback"></div>
                                                        </div>

                                                        <div class="form-footer">
                                                            <button type="submit" class="btn btn-outline-primary-2" name='CHECK' id='CHECK' data-dismiss="modal" disabled>CHECK</button>
                                                        </div><!-- End .form-footer -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- .End .tab-pane -->
                            </div><!-- End .tab-content -->
                        </div><!-- End .form-tab -->
                    </div><!-- End .form-box -->
                </div><!-- End .container -->
            </div><!-- End .login-page section-bg -->
        </main>

    </div>

    <?php //include 'header/ScriptHom.html'; 
    ?>
    <script src="../Ajax/verification_email.js"></script>
</body>

</html>