<?php
include('connexion/connexion-DB.php');

// Paramètres pour la pagination
$limit = 12; // Nombre de produits par page (multiple de 4)
$page = $_GET['page'] ?? 1; // Numéro de la page actuelle

// Calcul de l'offset pour la requête SQL
$offset = ($page - 1) * $limit;

$sql = "SELECT DISTINCT l.ISBN, l.img_livre, l.prix, l.titre_livre, a.nom_auteur, a.prenom_auteur, l.reduction
    FROM auteur a
    JOIN livre l ON a.id_auteur=l.id_auteur
    LIMIT $limit OFFSET $offset";
$result = $connexion->query($sql);

// Récupérer tous les livres dans un tableau
$books = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sql2 = "SELECT COUNT(br.review_id) AS nmbr_vote, AVG(br.rating_client) AS rating_client
            FROM book_review br
            WHERE ISBN = '" . $row['ISBN'] . "'";
        $result2 = $connexion->query($sql2);

        $nmbr_vote = 0;
        $rating_client = 0;

        if ($result2->num_rows > 0) {
            $row2 = $result2->fetch_assoc();
            $nmbr_vote = $row2['nmbr_vote'];
            $rating_client = $row2['rating_client'];
        }
        
        $row['nmbr_vote'] = $nmbr_vote;
        $row['rating_client'] = $rating_client;
        $books[] = $row;
    }
}

if (count($books) > 0) {
    echo '<div class="products mb-3">';
    echo '<div class="row justify-content-center" id="resultats">';
    
    // Diviser les livres en rangées de 4
    $chunks = array_chunk($books, 4);
    
    foreach ($chunks as $chunk) {
        
        foreach ($chunk as $book) {
            $prix = $book["prix"];
            $reduction = $book["reduction"];
            $prix_avec_reduction = number_format(($prix * (1 - $reduction * 0.01)), 2);
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
                            <div class="ratings-val" style="width: <?php echo ceil($book['rating_client']) * 100 / 5; ?>%;"></div>
                        </div><!-- End .ratings -->
                        <span class="ratings-text">( <?php echo $book['nmbr_vote']; ?> Reviews )</span>
                    </div><!-- End .rating-container -->
                </div><!-- End .product-body -->
            </div><!-- End .product -->
        </div><!-- End .col-book -->
<?php
        }
    }

    echo '</div><!-- End .row -->';
    echo '</div><!-- End .products -->';

    $total_pages_sql = "SELECT COUNT(DISTINCT l.ISBN) as total FROM livre l";
    $result_total = $connexion->query($total_pages_sql);
    $row_total = $result_total->fetch_assoc();
    $total_pages = ceil($row_total['total'] / $limit);

    echo '<nav aria-label="Page navigation">';
    echo '<ul class="pagination justify-content-center">';

    // Bouton précédent
    echo '<li class="page-item ' . ($page == 1 ? 'disabled' : '') . '">';
    echo '<a class="page-link page-link-prev" href="' . ($page == 1 ? '#' : '?page=' . ($page - 1)) . '" aria-label="Previous" tabindex="-1" aria-disabled="true">';
    echo '<span aria-hidden="true"><i class="icon-long-arrow-left"></i></span>Prev';
    echo '</a>';
    echo '</li>';

    // Nombres de page
    for ($i = 1; $i <= $total_pages; $i++) {
        echo '<li class="page-item ' . ($page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
    }

    // Total de pages
    echo '<li class="page-item-total">of ' . $total_pages . '</li>';

    // Bouton suivant
    echo '<li class="page-item ' . ($page == $total_pages ? 'disabled' : '') . '">';
    echo '<a class="page-link page-link-next" href="' . ($page == $total_pages ? '#' : '?page=' . ($page + 1)) . '" aria-label="Next">';
    echo 'Next <span aria-hidden="true"><i class="icon-long-arrow-right"></i></span>';
    echo '</a>';
    echo '</li>';

    echo '</ul>';
    echo '</nav>';
} else {
    echo 'Aucun produit trouvé.';
}

// Fermer la connexion à la base de données
$connexion->close();
?>

<style>
    /* Style pour assurer 5 colonnes égales */
    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }
    
    .col-book {
        width: 25%;
        padding: 0 10px;
        margin-bottom: 20px;
        box-sizing: border-box;
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