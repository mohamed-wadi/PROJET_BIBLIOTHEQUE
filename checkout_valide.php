<?php include('connexion/test_connexion.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include('header/HeadHom.html'); ?>
</head>

<body>

    <div class="page-wrapper">
        <?php include("header/header_client.php"); ?>
        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">My products <span>Shop</span></h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">

            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <table class="table table-wishlist table-mobile">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Date of Buy</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>

                        <?php
                        if (isset($_SESSION['id_client'])) {
                            $userId = $_SESSION['id_client'];

                            $fetchProductSql = "SELECT l.img_livre, l.ISBN, l.titre_livre, l.Emplacement, l.prix, DATE_FORMAT(b.date_buy, '%Y/%m/%d') as formatted_date
                                                FROM livre l
                                                JOIN buy b ON b.ISBN = l.ISBN
                                                JOIN (
                                                    SELECT ISBN, MAX(date_buy) AS max_date
                                                    FROM buy
                                                    GROUP BY ISBN
                                                ) max_buy ON b.ISBN = max_buy.ISBN AND b.date_buy = max_buy.max_date
                                                WHERE b.id_client = ? 
                                                AND DATEDIFF(CURDATE(), b.date_buy) <= 15;";
                            $fetchProductStmt = $connexion->prepare($fetchProductSql);
                            $fetchProductStmt->bind_param("i", $userId);
                            $fetchProductStmt->execute();
                            $productResult = $fetchProductStmt->get_result();

                            if ($productResult->num_rows > 0) {
                                while ($productData = $productResult->fetch_assoc()) {
                                    echo '<tr>
                            <td class="product-col">
                                <div class="product">
                                    <figure class="product-media">
                                        <a href="#">
                                            <img src="' . $productData['img_livre'] . '" alt="Product image">
                                        </a>
                                    </figure>
                                    <h3 class="product-title">
                                        <a href="#">
                                            ' . $productData['titre_livre'] . '
                                        </a>
                                    </h3>
                                </div>
                            </td>
                            <td class="price-col">$' . $productData['prix'] . '</td>
                            <td class="stock-col"><span class="in-stock">' . $productData['formatted_date'] . '</span></td>
                            <td class="action-col">
                                <a href="download.php?ISBN=' . $productData['ISBN'] . '" class="btn btn-block btn-outline-primary-2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cloud-arrow-down" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.646 10.854a.5.5 0 0 0 .708 0l2-2a.5.5 0 0 0-.708-.708L8.5 9.293V5.5a.5.5 0 0 0-1 0v3.793L6.354 8.146a.5.5 0 1 0-.708.708z" />
                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383m.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                    </svg>
                                    &nbsp; &nbsp; Download
                                </a>
                            </td>
                        </tr>';
                                }
                            } else {
                                echo '<tr><td colspan="5">No purchases yet.</td></tr>';
                            }
                        } else {
                            header("Location: login.php");
                            exit();
                        }
                        ?>
                    </table><!-- End .table table-wishlist -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->

        </main><!-- End .main -->
        <?php include("includ/footer.php") ?>
    </div><!-- End .page-wrapper -->

    <?php 
    include("includ/menu_telephone.php");
    include('header/ScriptHom.html'); 
    ?>
</body>

</html>