<?php

$connecter = false;
if (isset($_SESSION['id_client'])) {
   $connecter = true;
   if ($_SESSION['role'] == "admin") {
       header("location:index_admin.php");
   }
}
?>
<!-- <script>
    $(document).ready(function() {
        var isbn = '<?php echo isset($_GET['isbn']) ? $_GET['isbn'] : ''; ?>';
        loadCartData();
        loadComments(isbn);
    });
</script> -->
<link rel="stylesheet" href="assets/css/fontawesome-free-6.5.1-web/css/all.css" />
<style>
    .btn-product.btn-cart {
        cursor: pointer;
    }

    .btn-product.btn-cart :hover {
        cursor: grabbing;
    }

    .btn-product.btn-wishlist {
        cursor: pointer;
    }

    .btn-product.btn-wishlist :hover {
        cursor: grabbing;
    }
</style>

<header class="header sticky-header">

    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <i class="icon-bars"></i>
                </button>

                <a href="index.php" class="logo">
                    <img src="assets/images/logo.png" alt="Molla Logo" width="105" height="25">
                </a>

                <nav class="main-nav">
                    <ul class="menu sf-arrows">
                        <li class="megamenu-container active">
                            <a href="index.php" class="sf-with-ul">Home</a>
                        </li>
                        <li>
                            <a href="category-4cols.php" class="sf-with-ul">Product</a>
                        </li>
                        <li>
                            <a href="about.php" class="sf-with-ul">About</a>
                        </li>
                        <li>
                            <a href="contact.php" class="sf-with-ul">Contact</a>
                        </li>
                        <li>
                            <a href="faq.php" class="sf-with-ul">FAQs</a>
                        </li>
                    </ul><!-- End .menu -->
                </nav>
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-search" style="padding-right: 30px;">
                    <a href="#" class="search-toggle" role="button" title="Search"><i class="icon-search"></i></a>
                    <form action="#" method="get">
                        <div class="header-search-wrapper">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="q" id="q" placeholder="Search in..." required>
                        </div><!-- End .header-search-wrapper -->
                    </form>
                </div><!-- End .header-search -->

                <?php if (!$connecter) { ?>
                    <div class="account">
                        <a href="connexion/login.php" title="Login/register">
                            <div class="icon text-center">
                                <i class="fa-solid fa-user-plus"></i>
                            </div>

                        </a>
                        <p>Login/register</p>
                    </div>

                <?php } else { ?>

                    <div class="dropdown cart-dropdown">
                        <a href="dashboard.php" class="dropdown-toggle">
                            <i class="icon-user"></i>
                        </a>
                    </div>

                    <div class="dropdown cart-dropdown">
                        <a href="wishlist.PHP" class="dropdown-toggle">
                            <i class="icon-heart-o"></i>
                            <span id="countwishlist" class="cart-count"></span>
                        </a>
                    </div>

                    <div class="dropdown cart-dropdown">
                        <a href="cart.php" class="dropdown-toggle">
                            <i class="icon-shopping-cart"></i>
                            <span class='cart-count' id="CartCount"></span>
                        </a>
                    </div>
                <?php } ?>
                
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->
</header><!-- End .header -->