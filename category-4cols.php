<?php include ('connexion/test_connexion.php'); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php include 'header/HeadHom.html'; ?>
    <!-- Main CSS File -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/plugins/owl-carousel/owl.carousel.css">
    <link rel="stylesheet" href="assets/css/plugins/magnific-popup/magnific-popup.css">
    <link rel="stylesheet" href="assets/css/plugins/nouislider/nouislider.css">
</head>

<body>
    <div class="page-wrapper">
        <?php include("header/header_client.php"); ?>
        <main class="main">
            <div class="page-header text-center" style="background-image: url('assets/images/page-header-bg.jpg')">
                <div class="container">
                    <h1 class="page-title">Products<span>Shop</span></h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->
            <nav aria-label="breadcrumb" class="breadcrumb-nav mb-2">
                <div class="container">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item"><a href="#">Shop</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Grid 4 Columns</li>
                    </ol>
                </div><!-- End .container -->
            </nav><!-- End .breadcrumb-nav -->

            <div class="page-content">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-9">

                            <div class="products mb-3">
                                <div class="row justify-content-center" id="resultats">
                                    <?php
                                    include("includ/get_books.php");
                                    include("includ/modal.php");
                                    ?>
                                </div>
                            </div>
                        </div><!-- End .col-lg-9 -->

                        <aside class="col-lg-3 order-lg-first">
                            <div class="widget widget-clean">
                                <label>Filters:</label>
                                <a href="#" class="sidebar-filter-clear" onclick="clearFilters()">Clear All</a>
                            </div>

                            <!-- Filter Categories -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-category" role="button" aria-expanded="true" aria-controls="widget-category">Category</a>
                                </h3>
                                <div class="collapse show" id="widget-category">
                                    <div class="widget-body" id="filter-categories"></div>
                                </div>
                            </div>

                            <!-- Filter Authors -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-author" role="button" aria-expanded="true" aria-controls="widget-author">Author</a>
                                </h3>
                                <div class="collapse" id="widget-author">
                                    <div class="widget-body" id="filter-authors"></div>
                                </div>
                            </div>

                            <!-- Filter by Year -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-year" role="button" aria-expanded="true" aria-controls="widget-year">Year</a>
                                </h3>
                                <div class="collapse" id="widget-year">
                                    <div class="widget-body" id="filter-years"></div>
                                </div>
                            </div>

                            <!-- Filter by Language -->
                            <div class="widget widget-collapsible">
                                <h3 class="widget-title">
                                    <a data-toggle="collapse" href="#widget-language" role="button" aria-expanded="true" aria-controls="widget-language">Language</a>
                                </h3>
                                <div class="collapse" id="widget-language">
                                    <div class="widget-body" id="filter-languages"></div>
                                </div>
                            </div>

                        </aside><!-- End .col-lg-3 -->
                    </div><!-- End .row -->
                </div><!-- End .container -->
            </div><!-- End .page-content -->
        </main><!-- End .main -->
        <?php include("includ/footer.php") ?>
    </div><!-- End .page-wrapper -->
    
    <?php include("includ/menu_telephone.php"); ?>
    <?php include('header/ScriptHom.html'); ?>

</body>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        loadFilters();

        // Ajouter un gestionnaire d'événements pour les changements de filtres
        document.querySelector('body').addEventListener('change', function(event) {
            if (event.target.matches('.custom-control-input')) {
                updateFilters();
            }
        });
    });

    function loadFilters() {
        ['categories', 'authors', 'years', 'languages', 'prices'].forEach(fetchFilters);
    }

    function fetchFilters(filterType) {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'includ/filterData.php?type=' + filterType, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById('filter-' + filterType).innerHTML = xhr.responseText;
            } else {
                console.error('AJAX Error:', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Network error.');
        };
        xhr.send();
    }

    function updateFilters() {
        let filters = {};
        document.querySelectorAll('.custom-control-input:checked').forEach(function(checkbox) {
            let idParts = checkbox.id.split('-');
            if (!filters[idParts[0]]) {
                filters[idParts[0]] = [];
            }
            filters[idParts[0]].push(idParts[1]);
        });

        let data = 'filters=' + encodeURIComponent(JSON.stringify(filters)) + '&page=1';
        var xhr = new XMLHttpRequest();
        xhr.open('GET', 'includ/fetchFilteredBooks.php?' + data, true);
        xhr.onload = function() {
            if (xhr.status >= 200 && xhr.status < 300) {
                document.getElementById('resultats').innerHTML = xhr.responseText;
            } else {
                console.error('Request failed: ', xhr.statusText);
            }
        };
        xhr.onerror = function() {
            console.error('Request failed.');
        };
        xhr.send();
    }

    function clearFilters() {
        document.querySelectorAll('.custom-control-input:checked').forEach(function(checkbox) {
            checkbox.checked = false;
        });
        updateFilters();  // Reload the book list without any filters
    }
</script>
</html>
