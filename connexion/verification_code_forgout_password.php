<?php
include('connexion-DB.php');
session_start();
$test_erreur = 0;
$message = "";

$info = 'info.txt';

// Read the content of the info file
$fileContent = file_get_contents($info);

// Split the content into an array using the pipe character as a separator
$data = explode(' | ', $fileContent);

// Assign values to variables
$Email = $data[0];
$code_verification = $data[1];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['CHECK_PASS'])) {
    $code = isset($_POST['code']) ? $_POST['code'] : '';

    if ($code == $code_verification) {
        // Clear the content of the info file
        file_put_contents('info.txt', '');

        // Check if the operation was successful
        if (file_get_contents('info.txt') === '') {

            // Redirect the user to the password.php page
            header("Location: password.php?Email=" . urlencode($Email));
            exit();
        } else {
            $message = "Une erreur de système.";
        }
    } else {
        // Incorrect verification code
        $test_erreur = 1;
        $message = "Code de vérification incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">


<!-- molla/login.html  22 Nov 2019 10:04:03 GMT -->

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
    <link rel="stylesheet" href="Admin_Style/style_livre.css">
</head>

<body>

    <div class="page-wrapper">
        <header class="header">

            <div class="header-middle sticky-header">
                <div class="container">
                    <div class="header-left">
                        <button class="mobile-menu-toggler">
                            <span class="sr-only">Toggle mobile menu</span>
                            <i class="icon-bars"></i>
                        </button>

                        <a href="index.html" class="logo">
                            <img src="assets/images/logo.png" alt="Molla Logo" width="105" height="25">
                        </a>

                        <nav class="main-nav">
                            <ul class="menu sf-arrows">
                                <li class="megamenu-container active">
                                    <a href="index.html" class="sf-with-ul">Home</a>
                                </li>
                                <li>
                                    <a href="category-4cols.html" class="sf-with-ul">Product</a>
                                </li>
                                <li>
                                    <a href="about.html" class="sf-with-ul">About</a>
                                </li>
                                <li>
                                    <a href="contact.html" class="sf-with-ul">Contact</a>
                                </li>
                                <li>
                                    <a href="faq.html" class="sf-with-ul">FAQs</a>
                                </li>

                                <li>
                                    <a href="#">Admin</a>

                                    <ul>
                                        <li>
                                            <a href="#">Book management</a>
                                            <ul>
                                                <li><a href="book_add.html">Add book</a></li>
                                                <li><a href="book_edit.html">Edit book</a></li>
                                                <li><a href="book_delete.html">Delete book</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">Author Management</a>
                                            <ul>
                                                <li><a href="Othor-Add.html">Add Author</a></li>
                                                <li><a href="Othor_Edit.html">Edit Author</a></li>
                                                <li><a href="Othor_Delete.html">Delete Author</a></li>
                                            </ul>
                                        </li>
                                        <li>
                                            <a href="#">User Management</a>
                                            <ul>
                                                <li><a href="User_Add.html">Add User</a></li>
                                                <li><a href="User_Edit.html">Edit User</a></li>
                                                <li><a href="User_Delete.html">Delete User</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                            </ul><!-- End .menu -->
                        </nav>
                    </div><!-- End .header-left -->

                    <div class="header-right">
                        <div class="header-search">
                            <a href="#" class="search-toggle" role="button" title="Search"><i
                                    class="icon-search"></i></a>
                            <form action="#" method="get">
                                <div class="header-search-wrapper">
                                    <label for="q" class="sr-only">Search</label>
                                    <input type="search" class="form-control" name="q" id="q" placeholder="Search in..."
                                        required>
                                </div><!-- End .header-search-wrapper -->
                            </form>
                        </div><!-- End .header-search -->
                        <div class="dropdown compare-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-display="static"
                                title="Compare Products" aria-label="Compare Products">
                                <i class="icon-random"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <ul class="compare-products">
                                    <li class="compare-product">
                                        <a href="#" class="btn-remove" title="Remove Product"><i
                                                class="icon-close"></i></a>
                                        <h4 class="compare-product-title"><a href="product.html">Blue Night Dress</a>
                                        </h4>
                                    </li>
                                    <li class="compare-product">
                                        <a href="#" class="btn-remove" title="Remove Product"><i
                                                class="icon-close"></i></a>
                                        <h4 class="compare-product-title"><a href="product.html">White Long Skirt</a>
                                        </h4>
                                    </li>
                                </ul>

                                <div class="compare-actions">
                                    <a href="#" class="action-link">Clear All</a>
                                    <a href="#" class="btn btn-outline-primary-2"><span>Compare</span><i
                                            class="icon-long-arrow-right"></i></a>
                                </div>
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .compare-dropdown -->

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false" data-display="static">
                                <i class="icon-shopping-cart"></i>
                                <span class="cart-count">2</span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right">
                                <div class="dropdown-cart-products">
                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="product.html">Beige knitted elastic runner shoes</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x $84.00
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="product.html" class="product-image">
                                                <img src="assets/images/products/cart/product-1.jpg" alt="product">
                                            </a>
                                        </figure>
                                        <a href="#" class="btn-remove" title="Remove Product"><i
                                                class="icon-close"></i></a>
                                    </div><!-- End .product -->

                                    <div class="product">
                                        <div class="product-cart-details">
                                            <h4 class="product-title">
                                                <a href="product.html">Blue utility pinafore denim dress</a>
                                            </h4>

                                            <span class="cart-product-info">
                                                <span class="cart-product-qty">1</span>
                                                x $76.00
                                            </span>
                                        </div><!-- End .product-cart-details -->

                                        <figure class="product-image-container">
                                            <a href="product.html" class="product-image">
                                                <img src="assets/images/products/cart/product-2.jpg" alt="product">
                                            </a>
                                        </figure>
                                        <a href="#" class="btn-remove" title="Remove Product"><i
                                                class="icon-close"></i></a>
                                    </div><!-- End .product -->
                                </div><!-- End .cart-product -->

                                <div class="dropdown-cart-total">
                                    <span>Total</span>

                                    <span class="cart-total-price">$160.00</span>
                                </div><!-- End .dropdown-cart-total -->

                                <div class="dropdown-cart-action">
                                    <a href="cart.html" class="btn btn-primary">View Cart</a>
                                    <a href="checkout.html" class="btn btn-outline-primary-2"><span>Checkout</span><i
                                            class="icon-long-arrow-right"></i></a>
                                </div><!-- End .dropdown-cart-total -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .cart-dropdown -->
                    </div><!-- End .header-right -->
                </div><!-- End .container -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->

        <main class="main">
            <nav aria-label="breadcrumb" class="breadcrumb-nav border-0 mb-0">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Admin</a></li>
                        <li class="breadcrumb-item"><a href="#">Book</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Edit</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="login-page bg-image pt-8 pb-8 pt-md-12 pb-md-12 pt-lg-17 pb-lg-17"
                style="background-image: url('assets/images/backgrounds/login-bg.jpg')">
                <div class="container">
                    <div class="form-box">
                        <div class="form-tab">
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="register-2" role="tabpanel"
                                    aria-labelledby="register-tab-2">
                                    <div class="card text-center">
                                        <div class="card-header"> </div>
                                        <div class="card-body">
                                            <h5 class="card-title">Code Verification</h5>
                                            <p class="card-text">Enter the code that was sent to you in this email
                                                <?php echo $Email?></p>
                                        </div>
                                        <div class="card-footer text-muted"> </div>
                                    </div>

                                    <form action="verification_code_forgout_password.php" method="POST">

                                        <div class="form-group">
                                            <input type="number" class="form-control" id="code" name="code"
                                                placeholder="Entre code verification"
                                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                maxlength="6" required>
                                        </div><!-- End .form-group -->


                                        <div class="form-footer">
                                            <input type="submit" value="CHECK" class="btn btn-outline-primary-2"
                                                name='CHECK_PASS'>
                                        </div><!-- End .form-footer -->

                                    </form>

                                    <?php if($test_erreur==1) { ?>
                                    <div class="form-footer">
                                        <div class="error">
                                            <div class="error__icon">
                                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                    viewBox="0 0 20 20">
                                                    <path
                                                        d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5Zm3.707 11.793a1 1 0 1 1-1.414 1.414L10 11.414l-2.293 2.293a1 1 0 0 1-1.414-1.414L8.586 10 6.293 7.707a1 1 0 0 1 1.414-1.414L10 8.586l2.293-2.293a1 1 0 0 1 1.414 1.414L11.414 10l2.293 2.293Z" />
                                                </svg>
                                            </div>
                                            <div class="error__title"><?php echo $message ?></div>
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

        <footer class="footer">
            <div class="footer-middle">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-6 col-lg-3">
                            <div class="widget widget-about">
                                <img src="assets/images/logo.png" class="footer-logo" alt="Footer Logo" width="105"
                                    height="25">
                                <p>Praesent dapibus, neque id cursus ucibus, tortor neque egestas augue, eu vulputate
                                    magna eros eu erat. </p>

                                <div class="social-icons">
                                    <a href="#" class="social-icon" target="_blank" title="Facebook"><i
                                            class="icon-facebook-f"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Twitter"><i
                                            class="icon-twitter"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Instagram"><i
                                            class="icon-instagram"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Youtube"><i
                                            class="icon-youtube"></i></a>
                                    <a href="#" class="social-icon" target="_blank" title="Pinterest"><i
                                            class="icon-pinterest"></i></a>
                                </div><!-- End .soial-icons -->
                            </div><!-- End .widget about-widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Useful Links</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="about.html">About Molla</a></li>
                                    <li><a href="#">How to shop on Molla</a></li>
                                    <li><a href="#">FAQ</a></li>
                                    <li><a href="contact.html">Contact us</a></li>
                                    <li><a href="login.html">Log in</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">Customer Service</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="#">Payment Methods</a></li>
                                    <li><a href="#">Money-back guarantee!</a></li>
                                    <li><a href="#">Returns</a></li>
                                    <li><a href="#">Shipping</a></li>
                                    <li><a href="#">Terms and conditions</a></li>
                                    <li><a href="#">Privacy Policy</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->

                        <div class="col-sm-6 col-lg-3">
                            <div class="widget">
                                <h4 class="widget-title">My Account</h4><!-- End .widget-title -->

                                <ul class="widget-list">
                                    <li><a href="#">Sign In</a></li>
                                    <li><a href="cart.html">View Cart</a></li>
                                    <li><a href="#">My Wishlist</a></li>
                                    <li><a href="#">Track My Order</a></li>
                                    <li><a href="#">Help</a></li>
                                </ul><!-- End .widget-list -->
                            </div><!-- End .widget -->
                        </div><!-- End .col-sm-6 col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .footer-middle -->

            <div class="footer-bottom">
                <div class="container">
                    <p class="footer-copyright">Copyright © 2019 Molla Store. All Rights Reserved.</p>
                    <!-- End .footer-copyright -->
                    <figure class="footer-payments">
                        <img src="assets/images/payments.png" alt="Payment methods" width="272" height="20">
                    </figure><!-- End .footer-payments -->
                </div><!-- End .container -->
            </div><!-- End .footer-bottom -->
        </footer><!-- End .footer -->
    </div><!-- End .page-wrapper -->
    <button id="scroll-top" title="Back to Top"><i class="icon-arrow-up"></i></button>

    <!-- Mobile Menu -->
    <div class="mobile-menu-overlay"></div><!-- End .mobil-menu-overlay -->

    <div class="mobile-menu-container">
        <div class="mobile-menu-wrapper">
            <span class="mobile-menu-close"><i class="icon-close"></i></span>

            <nav class="mobile-nav">
                <ul class="mobile-menu">
                    <li>
                        <a href="index.html">Home</a>
                    </li>
                    <li>
                        <a href="category-4cols.html">Product</a>
                    </li>
                    <li>
                        <a href="about.html" class="sf-with-ul">About</a>
                    </li>
                    <li>
                        <a href="contact.htm">Contact</a>
                    </li>
                    <li>
                        <a href="faq.html">FAQs</a>
                    </li>
                    <li>
                        <a href="#">Admin</a>

                        <ul>
                            <li>
                                <a href="#">Book management</a>
                                <ul>
                                    <li><a href="book_add.html">Add book</a></li>
                                    <li><a href="book_edit.html">Edit book</a></li>
                                    <li><a href="book_delete.html">Delete book</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">Author Management</a>
                                <ul>
                                    <li><a href="Othor-Add.html">Add Author</a></li>
                                    <li><a href="Othor_Edit.html">Edit Author</a></li>
                                    <li><a href="Othor_Delete.html">Delete Author</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="#">User Management</a>
                                <ul>
                                    <li><a href="User_Add.html">Add User</a></li>
                                    <li><a href="User_Edit.html">Edit User</a></li>
                                    <li><a href="User_Delete.html">Delete User</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </nav><!-- End .mobile-nav -->

            <div class="social-icons">
                <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
                <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
            </div><!-- End .social-icons -->
        </div><!-- End .mobile-menu-wrapper -->
    </div><!-- End .mobile-menu-container -->

    <!-- Plugins JS File -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/jquery.hoverIntent.min.js"></script>
    <script src="assets/js/jquery.waypoints.min.js"></script>
    <script src="assets/js/superfish.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <!-- Main JS File -->
    <script src="assets/js/main.js"></script>
</body>


<!-- molla/login.html  22 Nov 2019 10:04:03 GMT -->

</html>