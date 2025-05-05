<?php
include("verification.php");
?>


<!doctype html>
<html lang="en">

<head>
    <?php
    include("../ADMIN_PAGES/head.html");
    include("../ADMIN_PAGES/script.html");
    ?>
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <div>
        <div class="page-wrapper">

            <?php include("header_admin.php"); ?>
            
            <main class="main">
                <div class="page-header text-center" style="background-image: url('../assets/images/page-header-bg.jpg')">
                    <div class="container">
                        <h1 class="page-title">Request<span>Pages</span></h1>
                    </div><!-- End .container -->
                </div><!-- End .page-header -->
                <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <div class="container">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index_admin.php">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Request</li>
                        </ol>
                    </div><!-- End .container -->
                </nav><!-- End .breadcrumb-nav -->

                <div class="page-content">
                    <div class="dashboard">
                        <div class="container">
                            <div class="row">
                                <div class="col">
                                <div class="table-responsive">
                                    <?php
                                    // Requête SQL pour récupérer les requêtes
                                    $requestSql = "SELECT * FROM request";
                                    $requestResult = $connexion->query($requestSql);
                                    if ($requestResult->num_rows > 0) {
                                        echo '<table class="table">
                                            <thead class="thead-dark">
                                                <tr>
                                                    <th class="text-center" scope="col">Number</th>
                                                    <th class="text-center" scope="col">Client Name</th>
                                                    <th class="text-center" scope="col">Email</th>
                                                    <th class="text-center" scope="col">Message</th>
                                                </tr>
                                            </thead>
                                            <tbody>';
                                        while ($requestRow = $requestResult->fetch_assoc()) {
                                            echo '
                                            <tr>
                                                <td class="number-col text-center">' . htmlspecialchars($requestRow['id_request']) . '</td>
                                                <td class="name-col text-center">' . htmlspecialchars($requestRow['name_client']) . '</td>
                                                <td class="email-col text-center">' . htmlspecialchars($requestRow['email_client']) . '</td>
                                                <td class="message-col text-center" style="max-width: 250px; ">' . htmlspecialchars($requestRow['message_request']) . '</td>
                                            </tr>';
                                        }
                                        echo '</tbody></table>';
                                    } else {
                                        echo "Aucune requête disponible.";
                                    }
                                    ?>
                                </div><!-- End .row -->
                            </div><!-- End .container -->
                        </div><!-- End .dashboard -->
                    </div><!-- End .page-content -->
            </main><!-- End .main -->
        </div>

        <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    </div>
<?php include("menu_telephone_admin.php"); ?>
</body>

</html>