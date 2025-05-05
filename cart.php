<?php include('connexion/test_connexion.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header/HeadHom.html'; ?>
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
                                    <tbody id="cart-body">
                                        <!-- Les éléments du panier seront ajoutés ici dynamiquement via JavaScript -->
                                    </tbody>
                                </table>
                            </div><!-- End .col-lg-9 -->
                            <aside class="col-lg-4">
                                <div class="summary summary-cart">
                                    <h3 class="summary-title">Cart Total</h3>
                                    <table class="table table-summary">
                                        <tbody>
                                            <tr class="summary-total">
                                                <td>Total:</td>
                                                <td id="cart-total"></td>
                                            </tr>
                                        </tbody>
                                    </table>

                                    <a href="checkout.php" class="btn btn-outline-primary-2 btn-order btn-block">PROCEED TO CHECKOUT</a>
                                </div><!-- End .summary -->

                                <a href="category-4cols.php" class="btn btn-outline-dark-2 btn-block mb-3">
                                    <span>CONTINUE SHOPPING</span>
                                    <i class="icon-refresh"></i>
                                </a>
                            </aside><!-- End .col-lg-4 -->
                        </div><!-- End .row -->

                    </div><!-- End .container -->
                </div><!-- End .cart -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <?php include("includ/footer.php") ?>
    </div>
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <?php 
    include("includ/menu_telephone.php");
    include("header/ScriptHom.html");
    ?>

</body>

</html>