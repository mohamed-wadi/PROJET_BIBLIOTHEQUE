<?php include ('connexion/test_connexion.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Molla - Bootstrap eCommerce Template</title>
    <meta name="keywords" content="HTML5 Template">
    <meta name="description" content="Molla - Bootstrap eCommerce Template">
    <meta name="author" content="p-themes">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="180x180" href="assets/images/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="assets/images/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/icons/favicon-16x16.png">
    <link rel="manifest" href="assets/images/icons/site.html">
    <link rel="mask-icon" href="assets/images/icons/safari-pinned-tab.svg" color="#666666">
    <link rel="shortcut icon" href="assets/images/icons/favicon.ico">
    <meta name="apple-mobile-web-app-title" content="Molla">
    <meta name="application-name" content="Molla">
    <meta name="msapplication-TileColor" content="#cc9966">
    <meta name="msapplication-config" content="assets/images/icons/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">
    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="page-wrapper">
        <?php include("header/header_client.php"); ?>
        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">Shopping Cart<span>Shop</span></h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Shopping Cart</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <?php
            $cartItems = [];
            $sql = "SELECT s.*, l.titre_livre, l.img_livre, l.prix
            FROM shoppingcart s
            JOIN livre l ON s.ISBN = l.ISBN
            WHERE id_client = ?";

            // Préparez la requête
            $stmt = $connexion->prepare($sql);

            // Liez le paramètre
            $stmt->bind_param("s", $_SESSION['id_client']);

            // Exécutez la requête
            $stmt->execute();

            // Récupérez le résultat
            $result = $stmt->get_result();

            // Si des lignes sont retournées, les ajouter à $cartItems
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $cartItems[] = $row;
                }
            }
            ?>
            <div class="page-content">
                <div class="cart">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <table class="table table-cart table-mobile">
                                    <thead>
                                        <tr>
                                            <th>Product</th>
                                            <th>Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <?php foreach ($cartItems as $cartItem) : ?>
                                                <tr>
                                                    <td class="product-col">
                                                        <div class="product">
                                                            <figure class="product-media">
                                                                <a href="#">
                                                                    <img src="<?php echo $cartItem['img_livre']; ?>" alt="Product image">
                                                                </a>
                                                            </figure>
                                                            <h3 class="product-title">
                                                                <a href="#"><?php echo $cartItem['titre_livre']; ?></a>
                                                            </h3><!-- End .product-title -->
                                                        </div><!-- End .product -->
                                                    </td>
                                                    <td class="price-col">$<?php echo number_format($cartItem['prix'], 2); ?></td>
                                                    <td class="remove-col">
                                                        <button type="submit" class="btn-remove" name="removeCartItem"><i class="icon-close"></i></button>
                                                    </td>
                                                </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table><!-- End .table table-wishlist -->
                            </div><!-- End .col-lg-9 -->

                            <aside class="col-lg-4">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3><!-- End .summary-title -->

                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td>
                                                    <?php echo '$' . number_format(array_sum(array_column($cartItems, 'prix')), 2); ?>
                                                </td>
                                            </tr><!-- End .summary-total -->
                                        </tbody>
                                    </table><!-- End .table table-summary -->

                                    <a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                                </div><!-- End .summary -->

                                <a href="category-4cols.php" class="btn btn-outline-dark-2 btn-block mb-3"><span>CONTINUE
                                        SHOPPING</span><i class="icon-refresh"></i></a>
                            </aside><!-- End .col-lg-4 -->
                        </div><!-- End .row -->
                    </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <?php include("includ/footer.php") ?>
    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <?php include('header/ScriptHom.html'); ?>
</body>

</html>