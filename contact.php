<?php

include ('connexion/test_connexion.php');

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les valeurs du formulaire
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    // Préparer la requête d'insertion
    $sql = "INSERT INTO request (name_client, email_client, phone_client, subject_request, message_request) VALUES ('$name', '$email', '$phone', '$subject', '$message')";

    // Exécuter la requête
    if ($connexion->query($sql) === FALSE) {
        echo "Erreur : " . $sql . "<br>" . $connexion->error;
    } else {
    }
}

$connexion->close();
?>

<!DOCTYPE html>
<html lang="en">


<head>
    <?php include 'header/HeadHom.html'; ?>
</head>

<body>
    <div class="page-wrapper">
        <?php include("header/header_client.php"); ?>

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Pages</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Contact us</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->
            <div class="container">
                <div class="page-header page-header-big text-center" style="background-image: url('assets/images/contact-header-bg.jpg')">
                    <h1 class="page-title text-white">Contact us<span class="text-white">keep in touch with us</span></h1>
                </div><!-- End .page-header -->
            </div><!-- End .container -->

            <div class="page-content pb-0">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-6 mb-2 mb-lg-0">
                            <h2 class="title mb-1">Contact Information</h2><!-- End .title mb-2 -->
                            <p class="mb-3">Vestibulum volutpat, lacus a ultrices sagittis, mi neque euismod dui, eu pulvinar nunc sapien ornare nisl. Phasellus pede arcu, dapibus eu, fermentum et, dapibus sed, urna.</p>
                            <div class="row">
                                <div class="col-sm-7">
                                    <div class="contact-info">
                                        <h3>The Office</h3>

                                        <ul class="contact-list">
                                            <li>
                                                <i class="icon-map-marker"></i>
CASBLANCA                                            </li>
                                            <li>
                                                <i class="icon-phone"></i>
                                                <a href="tel:#">+92 423 567</a>
                                            </li>
                                            <li>
                                                <i class="icon-envelope"></i>
                                                <a href="mailto:#">shm@gmail.com</a>
                                            </li>
                                        </ul><!-- End .contact-list -->
                                    </div><!-- End .contact-info -->
                                </div><!-- End .col-sm-7 -->

                                <div class="col-sm-5">
                                    <div class="contact-info">
                                        <h3>The Office</h3>

                                        <ul class="contact-list">
                                            <li>
                                                <i class="icon-clock-o"></i>
                                                <span class="text-dark">Monday-Saturday</span> <br>11am-7pm ET
                                            </li>
                                            <li>
                                                <i class="icon-calendar"></i>
                                                <span class="text-dark">Sunday</span> <br>11am-6pm ET
                                            </li>
                                        </ul><!-- End .contact-list -->
                                    </div><!-- End .contact-info -->
                                </div><!-- End .col-sm-5 -->
                            </div><!-- End .row -->
                        </div><!-- End .col-lg-6 -->
                        <div class="col-lg-6">
                            <h2 class="title mb-1">Got Any Questions?</h2><!-- End .title mb-2 -->
                            <p class="mb-2">Use the form below to get in touch with the sales team</p>

                            <form action="contact.PHP" method="POST" class="contact-form mb-3">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="cname" class="sr-only">Name</label>
                                        <input type="text" class="form-control" id="cname" name="name" placeholder="Name *" required>
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label for="cemail" class="sr-only">Email</label>
                                        <input type="email" class="form-control" id="cemail" name="email" placeholder="Email *" required>
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <div class="row">
                                    <div class="col-sm-6">
                                        <label for="cphone" class="sr-only">Phone</label>
                                        <input type="tel" class="form-control" id="cphone" name="phone" placeholder="Phone">
                                    </div><!-- End .col-sm-6 -->

                                    <div class="col-sm-6">
                                        <label for="csubject" class="sr-only">Subject</label>
                                        <input type="text" class="form-control" id="csubject" name="subject" placeholder="Subject">
                                    </div><!-- End .col-sm-6 -->
                                </div><!-- End .row -->

                                <label for="cmessage" class="sr-only">Message</label>
                                <textarea class="form-control" cols="30" rows="4" id="cmessage" name="message" required placeholder="Message *"></textarea>

                                <button type="submit" class="btn btn-outline-primary-2 btn-minwidth-sm">
                                    <span>SUBMIT</span>
                                    <i class="icon-long-arrow-right"></i>
                                </button>
                            </form><!-- End .contact-form -->
                        </div><!-- End .col-lg-6 -->
                    </div><!-- End .row -->

                    <hr class="mt-4 mb-5">


                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main>
        
        <?php include("includ/footer.php") ?>
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <?php 
    include("includ/menu_telephone.php");
    include('header/ScriptHom.html'); 
    ?>
</body>

</html>