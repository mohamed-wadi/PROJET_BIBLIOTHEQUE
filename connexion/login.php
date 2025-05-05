<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('../header/head.html') ?>
</head>

<body>
    <div class="page-wrapper">
        <main class="main">
            <div class="login-page bg-image pt-4 pb-4 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17" style="background-image: url('../assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <ul class="nav nav-pills nav-fill" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="signin-tab-2" data-toggle="tab" href="#signin-2" role="tab" aria-controls="signin-2" aria-selected="false">Sign In</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link " id="register-tab-2" data-toggle="tab" href="#register-2" role="tab" aria-controls="register-2" aria-selected="true">Register</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="signin-2" role="tabpane1" aria-labelledby="signin-tab-2">
                                    <form id="login-form">
                                        <div class="form-group">
                                            <label class="form-label">Email address</label>
                                            <div class="input-group has-validation">
                                                <input type="text" name="Email" class="form-control" id="validationServerEmail" required>
                                                <div id="error-message-email" class="invalid-feedback"></div>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="singin-password-2">Password</label>
                                            <div class="input-group has-validation">
                                                <input type="password" class="form-control" id="validationServerPassword" name="MDP" required>
                                                <div id="error-message-password" class="invalid-feedback"></div>
                                            </div>
                                        </div>

                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-outline-primary-2" name='signin'>
                                                <span>LOG IN</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div>
                                    </form>

                                    <div class="form-footer">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="signin-remember-2">
                                            <label class="custom-control-label" for="signin-remember-2">Remember Me</label>
                                        </div><!-- End .custom-checkbox -->

                                        <a href="verification_email.php" class="forgot-link">Forgot Your Password?</a>
                                    </div><!-- End .form-footer -->

                                </div>

                                <div class="tab-pane fade " id="register-2" role="tabpane2" aria-labelledby="register-tab-2">
                                    <form id="register-form">
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
                                            <label for="register-date-2">Date of birthey *</label>
                                            <div class="input-group has-validation">
                                                <input type="date" class="form-control" id="register-date-2" name="date_naissance" require>
                                            </div>
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
                                                    <div class="input-group has-validation">
                                                        <input type="tel" id="typePhone" class="form-control" name="phone" maxlength="10" value="0000000000" required />
                                                        <div id="error-number" class="invalid-feedback">The number is invalid.</div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">Your email address *</label>
                                            <div class="input-group has-validation">
                                                <input type="email" class="form-control" id="Email" name="email" placeholder="Entre your number " value="test@example.com" required>
                                                <div id="error-email" class="invalid-feedback">The email is invalid.</div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="register-password-2">Password *</label>
                                            <input type="password" class="form-control" name="MDP" required>
                                        </div>

                                        <div class="form-footer" id="validDiv">
                                            <button type="button" class="btn btn-outline-primary-2" id="validButton" disabled>
                                                <span>Valid</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div>

                                        <div class="form-footer" id="register" style="display: none;">
                                            <button type="submit" class="btn btn-outline-primary-2" name="register" id="register-button">
                                                <span>SIGN UP</span>
                                                <i class="icon-long-arrow-right"></i>
                                            </button>
                                        </div>
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
                                                                <p class="card-text" id="email_client"></p> <!-- Cet élément doit être présent -->
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
        </main><!-- End .main -->

    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <script src="../Ajax/reg.js"></script>
    <script src="../Ajax/register.js"></script>
    <script src="../Ajax/login.js"></script>
    <script src="//cdn.tutorialjinni.com/bootstrap-select/1.12.4/js/bootstrap-select.min.js"></script>
    <script src="//g.tutorialjinni.com/mojoaxel/bootstrap-select-country/dist/js/bootstrap-select-country.min.js"></script>

</body>

</html>