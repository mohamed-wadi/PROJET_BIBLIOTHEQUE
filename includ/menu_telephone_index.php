<div class="mobile-menu-overlay"></div>

<div class="mobile-menu-container">
    <div class="mobile-menu-wrapper">
        <span class="mobile-menu-close"><i class="icon-close"></i></span>

        <form action="#" method="get" class="mobile-search">
            <label for="mobile-search" class="sr-only">Search</label>
            <input type="search" class="form-control text-muted" name="mobile-search" id="mobile-search" placeholder="Search..." required>
            <button class="btn btn-primary" type="submit"><i class="icon-search"></i></button>
            <ul class="dropdown-menu w-100" id="searchDropdownMenu">
                <li><a class="dropdown-item" href="#">Action</a></li>
                <li><a class="dropdown-item" href="#">Another action</a></li>
                <li><a class="dropdown-item" href="#">Something else here</a></li>
            </ul>
        </form>

        <ul class="nav nav-pills-mobile" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="mobile-menu-link" data-toggle="tab" href="#mobile-menu-tab" role="tab" aria-controls="mobile-menu-tab" aria-selected="true">Menu</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="mobile-cats-link" data-toggle="tab" href="#mobile-cats-tab" role="tab" aria-controls="mobile-cats-tab" aria-selected="false">Categories</a>
            </li>
        </ul>

        <div class="tab-content">
            <div class="tab-pane fade show active" id="mobile-menu-tab" role="tabpanel" aria-labelledby="mobile-menu-link">
                <nav class="mobile-nav">
                    <ul class="mobile-menu">
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
                </nav><!-- End .mobile-nav -->
            </div><!-- .End .tab-pane -->
            <div class="tab-pane fade" id="mobile-cats-tab" role="tabpanel" aria-labelledby="mobile-cats-link">
                <nav class="mobile-cats-nav">
                    <ul class="mobile-cats-menu">
                        <li><a class="mobile-cats-lead" href="#">Best Books of 2024</a></li>
                        <li><a class="mobile-cats-lead" href="#">New for 2024</a></li>
                        <li><a class="mobile-cats-lead" href="#">Best Books of 2024</a></li>
                        <li><a class="mobile-cats-lead" href="#">New for 2024</a></li>
                        <?php
                        include("connexion/connexion-DB.php");
                        $query = "SELECT genre FROM livre GROUP BY genre";
                        $result = $connexion->query($query);
                        // Affichage des boutons pour chaque genre
                        while ($row = $result->fetch_assoc()) {
                        ?>
                            <li><a class="mobile-cats-lead" href="#"><?php echo $row['genre']; ?></a></li>
                        <?php } ?>
                    </ul><!-- End .mobile-cats-menu -->
                </nav><!-- End .mobile-cats-nav -->
            </div><!-- .End .tab-pane -->
        </div><!-- End .tab-content -->

        <div class="social-icons">
            <a href="#" class="social-icon" target="_blank" title="Facebook"><i class="icon-facebook-f"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Twitter"><i class="icon-twitter"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Instagram"><i class="icon-instagram"></i></a>
            <a href="#" class="social-icon" target="_blank" title="Youtube"><i class="icon-youtube"></i></a>
        </div><!-- End .social-icons -->
    </div><!-- End .mobile-menu-wrapper -->
</div><!-- End .mobile-menu-container -->

<script>
    document.addEventListener("DOMContentLoaded", function() {
        var searchInput = document.getElementById("mobile-search");
        var searchDropdown = document.getElementById("searchDropdownMenu");

        searchInput.addEventListener("click", function() {
            searchDropdown.classList.toggle("show");
        });

        // Fermer le menu déroulant lorsque l'utilisateur clique en dehors
        window.addEventListener("click", function(event) {
            if (!event.target.matches('#mobile-search')) {
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