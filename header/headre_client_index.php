<script src="assets/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/jquery.min.js"></script>
<script src="Ajax/AddToCart.js"></script>
<script src="Ajax/AddToWishList.js"></script>

<link rel="stylesheet" href="assets/css/fontawesome-free-6.5.1-web/css/all.css" />

<header class="header header-12 ">
    <div class="header-middle sticky-header">
        <div class="container">
            <div class="header-left">
                <button class="mobile-menu-toggler">
                    <i class="icon-bars"></i>
                </button>

                <a href="index.php" class="logo">
                    <img src="assets/images/demos/demo-20/logoshm.svg" alt="Molla Logo" width="115" height="45">
                </a>
            </div><!-- End .header-left -->

            <div class="header-right">
                <div class="header-search header-search-extended header-search-visible header-search-no-radius">
                    <a href="#" class="search-toggle" role="button"><i class="icon-search"></i></a>
                    <form action="category-4cols.php" method="get">
                        <div class="header-search-wrapper search-wrapper-wide">
                            <label for="q" class="sr-only">Search</label>
                            <input type="search" class="form-control" name="products" id="searchInput" placeholder="Search ..." required>
                            <button class="btn btn-primary" type="submit" name="search_form"><i class="icon-search"></i></button>
                        </div><!-- End .header-search-wrapper -->
                            <ul class="dropdown-menu w-100" id="searchDropdown">
                                <li><a class="dropdown-item" href="#">Action</a></li>
                                <li><a class="dropdown-item" href="#">Another action</a></li>
                                <li><a class="dropdown-item" href="#">Something else here</a></li>
                            </ul>
                    </form>
                </div><!-- End .header-search -->

                <div class="header-dropdown-link">

                    <?php if (!$connecter) { ?>
                        <div class="dropdown cart-dropdown">
                            <a href="connexion/login.php" title="Login/register">
                                <div class="icon">
                                    <i class="fa-solid fa-user-plus"></i>
                                </div>
                                <p>Login/register</p>
                            </a>
                        </div><!-- End .compare-dropdown -->
                    <?php } else { ?>


                        <div class="account">
                            <a href="dashboard.php" title="My account">
                                <div class="icon">
                                    <i class="icon-user"></i>
                                </div>
                                <p>Account</p>
                            </a>
                        </div><!-- End .compare-dropdown -->

                        <div class="dropdown cart-dropdown">
                            <a href="wishlist.php" class="dropdown-toggle">
                                <div class="icon">
                                    <i class="icon-heart-o"></i>
                                    <span class='cart-count' id="countwishlist"></span>
                                </div>
                                <p>Wishlist</p>
                            </a>
                        </div><!-- End .wishlist -->

                        <div class="dropdown cart-dropdown">
                            <a href="cart.php" class="dropdown-toggle">
                                <div class="icon">
                                    <i class='icon-shopping-cart'></i>
                                    <span class='cart-count' id="CartCount"></span>
                                </div>
                                <p>Cart</p>
                            </a>
                        </div><!-- End .cart-dropdown -->

                    <?php } ?>
                </div>
            </div><!-- End .header-right -->
        </div><!-- End .container -->
    </div><!-- End .header-middle -->

    <div class="header-bottom ">
        <div class="container">
            <div style="background-color: #161A30; display: flex; width: 100%;">
                <div class="header-left">
                    <div class="dropdown category-dropdown">
                        <a href="#" class="dropdown-toggle" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static" title="Browse Categories">
                            Browse Categories
                        </a>

                        <div class="dropdown-menu">
                            <nav class="side-nav">
                                <ul class="menu-vertical sf-arrows">

                                    <form action="" method="get">
                                        <li class="item-lead">
                                            <button type="submit" name="category" class="btn btn-link" value="best_books_2024">Best Books of 2024</button>
                                        </li>
                                        <li class="item-lead">
                                            <button type="submit" name="category" class="btn btn-link" value="New_for_2024">New for 2024</button>
                                        </li>
                                        <?php
                                        $query = "SELECT genre FROM livre GROUP BY genre";
                                        $result = $connexion->query($query);
                                        // Affichage des boutons pour chaque genre
                                        while ($row = $result->fetch_assoc()) {
                                        ?>
                                            <li>
                                                <button type="submit" name="category" class="btn btn-link" value="<?php echo $row['genre']; ?>"><?php echo $row['genre']; ?></button>
                                            </li>
                                        <?php } ?>
                                    </form>

                                </ul><!-- End .menu-vertical -->
                            </nav><!-- End .side-nav -->
                        </div><!-- End .dropdown-menu -->
                    </div><!-- End .category-dropdown -->
                </div><!-- End .header-left -->
                <div class="header-center">
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
                        </ul>
                    </nav>
                </div>

                <!-- <div class="header-right">
                            <i class="la la-lightbulb-o"></i><p>Clearance Up to 30% Off</p>
                        </div> -->
            </div>
        </div><!-- End .container -->
    </div><!-- End .header-bottom -->
</header><!-- End .header -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById("searchInput");
        var searchDropdown = document.getElementById("searchDropdown");

        searchInput.addEventListener("click", function() {
            searchDropdown.classList.toggle("show");
        });

        // Fermer le menu déroulant lorsque l'utilisateur clique en dehors
        window.addEventListener("click", function(event) {
            if (!event.target.matches('#searchInput')) {
                var dropdowns = document.getElementsByClassName("dropdown-menu");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        });
    });
</script>