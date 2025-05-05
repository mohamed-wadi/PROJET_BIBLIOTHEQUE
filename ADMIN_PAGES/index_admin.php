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
    <style>
        .card-body {
            padding-right: 12px;
            padding-top: 12px;
            padding-bottom: 12px;
            background-color: white;
        }

        .card {
            background-color: #161A30;
            padding-bottom: 10px;
            padding-top: 10px;
            /* border-top-width: 0px; */
            /* border-bottom-width: 0px; */
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <?php include("header_admin.php"); ?>
        <main class="main">

            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item active" aria-current="page">Home</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->



            <div class="wrapper">
                <div id="body" class="active">
                    <!-- end of navbar navigation -->
                    <div class="content">
                        <div class="container">
                            <div class="bestseller-products">
                                <div class="block">
                                    <div class="block-wrapper ">
                                        <div class="container">
                                            <div class="row">

                                                <div class="card col-sm text-center">
                                                    <a href="#" class="text-decoration-none text-dark">
                                                        <div class="card-body">
                                                            <div class="dfd text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" color="#b5cc18" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                                                                    <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                                                                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                                    <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                                                                </svg>
                                                                <?php
                                                                $MONTHSalesSql = "SELECT SUM(price) as totalSales FROM buy";
                                                                $MONTHSalesResult = $connexion->query($MONTHSalesSql);

                                                                if ($MONTHSalesResult->num_rows > 0) {
                                                                    $MONTHSalesRow = $MONTHSalesResult->fetch_assoc();
                                                                    $totalSales = $MONTHSalesRow['totalSales'];
                                                                    
                                                                    if($totalSales){
                                                                        echo '<h4 class="mb-0">' . number_format($totalSales,2) . ' $</h4>';
                                                                    }else{
                                                                        echo '<h4 class="mb-0">00.00 $</h4>';
                                                                    }
                                                                    
                                                                } else {
                                                                    echo '<h4 class="mb-0">00.00</h4>';
                                                                }
                                                                ?>
                                                                <p class="text-muted text-uppercase">TOTAL ICOME
                                                                </p>
                                                            </div>
                                                            <div class="footer">
                                                                <hr />
                                                                <div class="stats">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-coin" viewBox="0 0 16 16">
                                                                        <path d="M5.5 9.511c.076.954.83 1.697 2.182 1.785V12h.6v-.709c1.4-.098 2.218-.846 2.218-1.932 0-.987-.626-1.496-1.745-1.76l-.473-.112V5.57c.6.068.982.396 1.074.85h1.052c-.076-.919-.864-1.638-2.126-1.716V4h-.6v.719c-1.195.117-2.01.836-2.01 1.853 0 .9.606 1.472 1.613 1.707l.397.098v2.034c-.615-.093-1.022-.43-1.114-.9zm2.177-2.166c-.59-.137-.91-.416-.91-.836 0-.47.345-.822.915-.925v1.76h-.005zm.692 1.193c.717.166 1.048.435 1.048.91 0 .542-.412.914-1.135.982V8.518z" />
                                                                        <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14m0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16" />
                                                                        <path d="M8 13.5a5.5 5.5 0 1 1 0-11 5.5 5.5 0 0 1 0 11m0 .5A6 6 0 1 0 8 2a6 6 0 0 0 0 12" />
                                                                    </svg> Forever
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-sm card text-center">
                                                    <a href="#" class="text-decoration-none text-dark">
                                                        <div class="card-body">
                                                            <div class="dfd text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" color="#b5cc18" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                                                    <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                                                                </svg>
                                                                <?php
                                                                $MONTHSalesSql = "SELECT COUNT(id_buy) as totalSales FROM buy WHERE YEAR(date_buy) = YEAR(NOW())";
                                                                $MONTHSalesResult = $connexion->query($MONTHSalesSql);

                                                                if ($MONTHSalesResult->num_rows > 0) {
                                                                    $MONTHSalesRow = $MONTHSalesResult->fetch_assoc();
                                                                    $totalSales = $MONTHSalesRow['totalSales'];
                                                                    echo '<h4 class="mb-0">' . htmlspecialchars($totalSales) . '</h4>';
                                                                } else {
                                                                    echo '<h4 class="mb-0">0</h4>';
                                                                }
                                                                ?>
                                                                <p class="text-muted text-uppercase">The Sales</p>
                                                            </div>
                                                            <div class="footer">
                                                                <hr />
                                                                <div class="stats">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart4" viewBox="0 0 16 16">
                                                                        <path d="M0 2.5A.5.5 0 0 1 .5 2H2a.5.5 0 0 1 .485.379L2.89 4H14.5a.5.5 0 0 1 .485.621l-1.5 6A.5.5 0 0 1 13 11H4a.5.5 0 0 1-.485-.379L1.61 3H.5a.5.5 0 0 1-.5-.5M3.14 5l.5 2H5V5zM6 5v2h2V5zm3 0v2h2V5zm3 0v2h1.36l.5-2zm1.11 3H12v2h.61zM11 8H9v2h2zM8 8H6v2h2zM5 8H3.89l.5 2H5zm0 5a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0m9-1a1 1 0 1 0 0 2 1 1 0 0 0 0-2m-2 1a2 2 0 1 1 4 0 2 2 0 0 1-4 0" />
                                                                    </svg> For this
                                                                    Month
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-sm card text-center">
                                                    <a href="#" class="text-decoration-none text-dark">
                                                        <div class="card-body">
                                                            <div class="dfd text-center">
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" color="#b5cc18" class="bi bi-mailbox-flag" viewBox="0 0 16 16">
                                                                    <path d="M10.5 8.5V3.707l.854-.853A.5.5 0 0 0 11.5 2.5v-2A.5.5 0 0 0 11 0H9.5a.5.5 0 0 0-.5.5v8zM5 7c0 .334-.164.264-.415.157C4.42 7.087 4.218 7 4 7s-.42.086-.585.157C3.164 7.264 3 7.334 3 7a1 1 0 0 1 2 0" />
                                                                    <path d="M4 3h4v1H6.646A4 4 0 0 1 8 7v6h7V7a3 3 0 0 0-3-3V3a4 4 0 0 1 4 4v6a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V7a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v6h6V7a3 3 0 0 0-3-3" />
                                                                </svg>

                                                                <i class="blue large-icon mb-2 fas fa-regular fa-envelope-open-text"></i>
                                                                <?php
                                                                // Requête SQL pour compter le nombre total de demandes de support pour cette semaine
                                                                $weekSupportRequestSql = "SELECT COUNT(id_request) as totalSupportRequests FROM request WHERE WEEK(date_request) = WEEK(NOW())";
                                                                $weekSupportRequestResult = $connexion->query($weekSupportRequestSql);

                                                                if ($weekSupportRequestResult->num_rows > 0) {
                                                                    $weekSupportRequestRow = $weekSupportRequestResult->fetch_assoc();
                                                                    $totalSupportRequests = $weekSupportRequestRow['totalSupportRequests'];
                                                                    echo '<h4 class="mb-0">' . htmlspecialchars($totalSupportRequests) . '</h4>';
                                                                } else {
                                                                    echo '<h4 class="mb-0">0</h4>'; // Aucune demande de support cette semaine
                                                                }
                                                                ?>
                                                                <p class="text-muted text-uppercase">Support
                                                                    Request</p>
                                                            </div>
                                                            <div class="footer">
                                                                <hr />
                                                                <div class="stats">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-mailbox-flag" viewBox="0 0 16 16">
                                                                        <path d="M10.5 8.5V3.707l.854-.853A.5.5 0 0 0 11.5 2.5v-2A.5.5 0 0 0 11 0H9.5a.5.5 0 0 0-.5.5v8zM5 7c0 .334-.164.264-.415.157C4.42 7.087 4.218 7 4 7s-.42.086-.585.157C3.164 7.264 3 7.334 3 7a1 1 0 0 1 2 0" />
                                                                        <path d="M4 3h4v1H6.646A4 4 0 0 1 8 7v6h7V7a3 3 0 0 0-3-3V3a4 4 0 0 1 4 4v6a1 1 0 0 1-1 1H1a1 1 0 0 1-1-1V7a4 4 0 0 1 4-4m0 1a3 3 0 0 0-3 3v6h6V7a3 3 0 0 0-3-3" />
                                                                    </svg> For
                                                                    this week

                                                                </div>
                                                            </div>

                                                        </div>
                                                    </a>
                                                </div>

                                                <div class="col-sm card text-center">
                                                    <a href="#" class="text-decoration-none text-dark">
                                                        <div class="card-body">
                                                            <div class="dfd text-center">

                                                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" color="#b5cc18" class="bi bi-envelope" viewBox="0 0 16 16">
                                                                    <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                                                </svg>
                                                                <?php
                                                                // Requête SQL pour compter le nombre total d'abonnés par e-mail pour cette semaine
                                                                $weekSubscribersSql = "SELECT COUNT(id) as totalSubscribers FROM email_subscribers";
                                                                $weekSubscribersResult = $connexion->query($weekSubscribersSql);

                                                                if ($weekSubscribersResult->num_rows > 0) {
                                                                    $weekSubscribersRow = $weekSubscribersResult->fetch_assoc();
                                                                    $totalSubscribers = $weekSubscribersRow['totalSubscribers'];
                                                                } else {
                                                                    $totalSubscribers = 0;
                                                                }
                                                                ?>
                                                                <h4 class="mb-0">
                                                                    <?= htmlspecialchars($totalSubscribers) ?>
                                                                </h4>
                                                                <p class="text-muted text-uppercase">E-MAIL
                                                                    SUBSCRIBERS</p>
                                                            </div>
                                                            <div class="footer">
                                                                <hr />
                                                                <div class="stats">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope" viewBox="0 0 16 16">
                                                                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2zm2-1a1 1 0 0 0-1 1v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1zm13 2.383-4.708 2.825L15 11.105zm-.034 6.876-5.64-3.471L8 9.583l-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h12a1 1 0 0 0 .966-.741M1 11.105l4.708-2.897L1 5.383z" />
                                                                    </svg> Forever
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>

                                            <?php
                                            include("graphe.php");
                                            ?>
                                        </div><!-- End .container -->
                                    </div><!-- End .block-wrapper -->
                                </div><!-- End .block -->
                            </div><!-- End .bg-light pt-4 pb-4 -->
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>
    <?php include("menu_telephone_admin.php"); ?>
</body>

</html>