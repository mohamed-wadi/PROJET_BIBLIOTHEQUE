<?php
include(__DIR__.'/../connexion/connexion-DB.php');  // Adjust this path to your actual DB connection script

$filters = isset($_GET['filters']) ? json_decode($_GET['filters'], true) : [];
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 15; // Pour avoir des rangées complètes de 5 produits
$offset = ($page - 1) * $limit;

function mapFilterToColumn($filterKey) {
    $mapping = [
        'cat' => 'l.genre',
        'author' => 'l.id_auteur',
        'year' => 'YEAR(l.date_publication)',  // Use YEAR() function for year filtering
        'lang' => 'l.langue',
        'price' => 'l.prix'
    ];
    return $mapping[$filterKey] ?? null;
}

$whereParts = [];
foreach ($filters as $key => $values) {
    $column = mapFilterToColumn($key);
    if (!empty($values) && $column) {
        $valuesList = implode(',', array_map(function($value) use ($connexion) {
            return '"' . mysqli_real_escape_string($connexion, $value) . '"';
        }, $values));
        $whereParts[] = "$column IN ($valuesList)";
    }
}

$whereSql = !empty($whereParts) ? ' WHERE ' . implode(' AND ', $whereParts) : '';
$sql = "SELECT DISTINCT l.ISBN, l.img_livre, l.prix, l.titre_livre, a.nom_auteur, a.prenom_auteur, l.reduction, 
               (SELECT COUNT(br.review_id) FROM book_review br WHERE br.ISBN = l.ISBN) AS nmbr_vote,
               (SELECT AVG(br.rating_client) FROM book_review br WHERE br.ISBN = l.ISBN) AS rating_client
        FROM auteur AS a
        JOIN livre AS l ON a.id_auteur = l.id_auteur
        $whereSql
        LIMIT $limit OFFSET $offset";

$result = $connexion->query($sql);

// Récupérer tous les livres dans un tableau
$books = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $books[] = $row;
    }
}

if (count($books) > 0) {
    // We'll use a single approach for all products to avoid inconsistencies
    echo '<div class="products mb-3">';
    
    // Special handling when there's only one product to ensure proper width
    if (count($books) == 1) {
        echo '<div class="row single-product-row">';
        $book = $books[0];
        $prix = $book["prix"];
        $reduction = $book["reduction"];
        $prix_avec_reduction = number_format(($prix * (1 - $reduction * 0.01)), 2);
        $rating_val = ceil($book['rating_client']) * 100 / 5;
        if (empty($rating_val) || is_null($rating_val)) {
            $rating_val = 0;
        }
        ?>
        <div class="col-book single-product">
            <div class="product product-7 text-center h-100">
                <figure class="product-media">
                    <a href="product.php?isbn=<?php echo $book['ISBN']; ?>">
                        <img src="<?php echo $book["img_livre"]; ?>" alt="Product image" class="product-image">
                    </a>

                    <div class="product-action-vertical">
                        <?php if ($connecter) { ?>
                            <a class="btn-product-icon btn-wishlist btn-expandable" onclick="addToWishlist('<?php echo $book['ISBN']; ?>')"><span>add to wishlist</span></a>
                        <?php } else {  ?>
                            <a class="btn-product-icon btn-wishlist btn-expandable" href="connexion/login.php"><span>add to wishlist</span></a>
                        <?php }  ?>

                        <a href="popup/quickView.php?isbn=<?php echo $book['ISBN']; ?>" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                    </div><!-- End .product-action-vertical -->

                    <div class="product-action">
                        <?php if ($connecter) { ?>
                            <a class="btn-product btn-cart" onclick="addToCart('<?php echo $book['ISBN']; ?>')"><span>add to cart</span></a>
                        <?php } else {  ?>
                            <a class="btn-product btn-cart" href="connexion/login.php"><span>add to cart</span></a>
                        <?php }  ?>
                    </div><!-- End .product-action -->
                </figure><!-- End .product-media -->

                <div class="product-body d-flex flex-column">
                    <div class="product-cat">
                        <a href="#"><?php echo $book["prenom_auteur"] . " " . $book["nom_auteur"]; ?></a>
                    </div><!-- End .product-cat -->
                    <h3 class="product-title"><a href="product.php?isbn=<?php echo $book['ISBN']; ?>"><?php echo $book["titre_livre"]; ?></a></h3>

                    <?php if ($book["reduction"] > 0) { ?>
                        <div class="product-price">
                            <span class="new-price"><?php echo $prix_avec_reduction; ?> $</span>
                            <span class="old-price">Was <s class="text-danger"><?php echo number_format($prix, 2); ?> $</s></span>
                        </div>
                    <?php } else { ?>
                        <div class="product-price">
                            <span class="price"><?php echo number_format($prix, 2); ?> $</span>
                        </div>
                    <?php } ?>
                    
                    <div class="ratings-container mt-auto">
                        <div class="ratings">
                            <div class="ratings-val" style="width: <?php echo $rating_val; ?>%;"></div>
                        </div><!-- End .ratings -->
                        <span class="ratings-text">( <?php echo $book['nmbr_vote']; ?> Reviews )</span>
                    </div><!-- End .rating-container -->
                </div><!-- End .product-body -->
            </div><!-- End .product -->
        </div><!-- End .col-book -->
        <?php
        // Add 3 empty slots to complete the row (for 4 products per row)
        for ($i = 0; $i < 3; $i++) {
            echo '<div class="col-book empty-book"></div>';
        }
        echo '</div>'; // End .row
    } else {
        echo '<div class="row">';
        
        // Diviser les livres en rangées de 4
        $chunks = array_chunk($books, 4);
        
        foreach ($chunks as $chunk) {
            // Add a specific class to help with styling
            echo '<div class="book-row d-flex w-100 mb-4" style="flex-wrap: wrap;">';
            
            foreach ($chunk as $book) {
                $prix = $book["prix"];
                $reduction = $book["reduction"];
                $prix_avec_reduction = number_format(($prix * (1 - $reduction * 0.01)), 2);
                $rating_val = ceil($book['rating_client']) * 100 / 5;
                if (empty($rating_val) || is_null($rating_val)) {
                    $rating_val = 0;
                }
                ?>
                <div class="col-book">
                    <div class="product product-7 text-center h-100">
                        <figure class="product-media">
                            <a href="product.php?isbn=<?php echo $book['ISBN']; ?>">
                                <img src="<?php echo $book["img_livre"]; ?>" alt="Product image" class="product-image">
                            </a>

                            <div class="product-action-vertical">
                                <?php if ($connecter) { ?>
                                    <a class="btn-product-icon btn-wishlist btn-expandable" onclick="addToWishlist('<?php echo $book['ISBN']; ?>')"><span>add to wishlist</span></a>
                                <?php } else {  ?>
                                    <a class="btn-product-icon btn-wishlist btn-expandable" href="connexion/login.php"><span>add to wishlist</span></a>
                                <?php }  ?>

                                <a href="popup/quickView.php?isbn=<?php echo $book['ISBN']; ?>" class="btn-product-icon btn-quickview" title="Quick view"><span>Quick view</span></a>
                            </div><!-- End .product-action-vertical -->

                            <div class="product-action">
                                <?php if ($connecter) { ?>
                                    <a class="btn-product btn-cart" onclick="addToCart('<?php echo $book['ISBN']; ?>')"><span>add to cart</span></a>
                                <?php } else {  ?>
                                    <a class="btn-product btn-cart" href="connexion/login.php"><span>add to cart</span></a>
                                <?php }  ?>
                            </div><!-- End .product-action -->
                        </figure><!-- End .product-media -->

                        <div class="product-body d-flex flex-column">
                            <div class="product-cat">
                                <a href="#"><?php echo $book["prenom_auteur"] . " " . $book["nom_auteur"]; ?></a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.php?isbn=<?php echo $book['ISBN']; ?>"><?php echo $book["titre_livre"]; ?></a></h3>

                            <?php if ($book["reduction"] > 0) { ?>
                                <div class="product-price">
                                    <span class="new-price"><?php echo $prix_avec_reduction; ?> $</span>
                                    <span class="old-price">Was <s class="text-danger"><?php echo number_format($prix, 2); ?> $</s></span>
                                </div>
                            <?php } else { ?>
                                <div class="product-price">
                                    <span class="price"><?php echo number_format($prix, 2); ?> $</span>
                                </div>
                            <?php } ?>
                            
                            <div class="ratings-container mt-auto">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: <?php echo $rating_val; ?>%;"></div>
                                </div><!-- End .ratings -->
                                <span class="ratings-text">( <?php echo $book['nmbr_vote']; ?> Reviews )</span>
                            </div><!-- End .rating-container -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
                </div><!-- End .col-book -->
                <?php
            }
            
            // Si la rangée n'est pas complète (moins de 4 livres), ajouter des cases vides
            $empty_slots = 4 - count($chunk);
            for ($i = 0; $i < $empty_slots; $i++) {
                echo '<div class="col-book empty-book"></div>';
            }
            
            echo '</div>'; // End .book-row
        }
        
        echo '</div>'; // End .row
    }
    
    echo '</div>'; // End .products

    // Pagination pour le filtrage (optionnel)
    $count_sql = "SELECT COUNT(DISTINCT l.ISBN) as total FROM auteur AS a JOIN livre AS l ON a.id_auteur = l.id_auteur $whereSql";
    $count_result = $connexion->query($count_sql);
    if ($count_result && $count_result->num_rows > 0) {
        $row = $count_result->fetch_assoc();
        $total_books = $row['total'];
        $total_pages = ceil($total_books / $limit);
        
        if ($total_pages > 1) {
            echo '<nav aria-label="Page navigation">';
            echo '<ul class="pagination justify-content-center">';
            
            // Bouton précédent
            $prev_disabled = ($page <= 1) ? 'disabled' : '';
            $prev_page = max(1, $page - 1);
            echo '<li class="page-item ' . $prev_disabled . '">';
            echo '<a class="page-link page-link-prev" href="javascript:void(0)" onclick="changePage(' . $prev_page . ')" aria-label="Previous">';
            echo '<span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev';
            echo '</a>';
            echo '</li>';
            
            // Pages
            for ($i = 1; $i <= $total_pages; $i++) {
                $active = ($i == $page) ? 'active' : '';
                echo '<li class="page-item ' . $active . '"><a class="page-link" href="javascript:void(0)" onclick="changePage(' . $i . ')">' . $i . '</a></li>';
            }
            
            // Total pages
            echo '<li class="page-item-total">of ' . $total_pages . '</li>';
            
            // Bouton suivant
            $next_disabled = ($page >= $total_pages) ? 'disabled' : '';
            $next_page = min($total_pages, $page + 1);
            echo '<li class="page-item ' . $next_disabled . '">';
            echo '<a class="page-link page-link-next" href="javascript:void(0)" onclick="changePage(' . $next_page . ')" aria-label="Next">';
            echo 'Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>';
            echo '</a>';
            echo '</li>';
            
            echo '</ul>';
            echo '</nav>';
        }
    }
} else {
    echo '<p class="text-center">Aucun produit ne correspond à vos critères de recherche.</p>';
}

$connexion->close();
?>

<style>
    /* Style pour assurer 5 colonnes égales */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
        width: 100%;
    }
    
    .book-row {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
        margin-left: 0;
        margin-right: 0;
        justify-content: flex-start;
    }
    
    .col-book {
        width: 25%;
        flex: 0 0 25%;
        max-width: 25%;
        min-width: 200px;
        padding: 0 10px;
        margin-bottom: 20px;
        box-sizing: border-box;
    }
    
    /* Empty book slots should be visible but empty */
    .empty-book {
        visibility: visible;
        height: auto;
    }
    
    /* Special styling for single product display */
    .single-product-row {
        display: flex;
        width: 100%;
        justify-content: flex-start;
    }
    
    .single-product {
        width: 25% !important;
        min-width: 220px !important;
        flex: 0 0 25% !important;
        max-width: 25% !important;
    }
    
    /* Style des cartes de livre */
    .product {
        transition: all 0.3s;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        overflow: hidden;
        background-color: #fff;
        height: 100%;
    }
    
    .product:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .product-media {
        background-color: #fff;
    }
    
    .product-image {
        height: 280px;
        object-fit: contain;
        padding: 10px;
        width: 100%;
        background-color: #fff;
    }
    
    .product-body {
        padding: 15px;
        height: 100%;
    }
    
    .product-title {
        font-size: 14px;
        height: 40px;
        overflow: hidden;
        margin-bottom: 10px;
    }
    
    .product-price {
        font-size: 15px;
        margin-bottom: 15px;
    }
    
    /* Responsive design */
    @media (max-width: 992px) {
        .col-book {
            width: 25%;
        }
        .col-book:nth-child(5n) {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .col-book {
            width: 33.333%;
        }
        .col-book:nth-child(4n), 
        .col-book:nth-child(5n) {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .col-book {
            width: 50%;
        }
        .col-book:nth-child(3n), 
        .col-book:nth-child(4n), 
        .col-book:nth-child(5n) {
            display: none;
        }
    }
</style>

<script>
function changePage(page) {
    let currentFilters = document.querySelectorAll('.custom-control-input:checked');
    let filters = {};
    
    currentFilters.forEach(function(checkbox) {
        let idParts = checkbox.id.split('-');
        if (!filters[idParts[0]]) {
            filters[idParts[0]] = [];
        }
        filters[idParts[0]].push(idParts[1]);
    });
    
    let data = 'filters=' + encodeURIComponent(JSON.stringify(filters)) + '&page=' + page;
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
</script>
