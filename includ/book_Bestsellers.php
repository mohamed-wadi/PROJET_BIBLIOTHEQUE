<?php
include("connexion/connexion-DB.php");

// Requête SQL pour obtenir les 5 livres les plus vendus
$sql = "SELECT l.ISBN,l.img_livre,a.prenom_auteur, a.nom_auteur, l.titre_livre, l.Paragraphe, l.prix,l.reduction
        FROM livre l 
        JOIN auteur a ON l.id_auteur = a.id_auteur
        GROUP BY l.ISBN
        LIMIT 5";

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
?>

<div class="container">
    <?php
    // Afficher une seule rangée de 5 bestsellers
    echo '<div class="row book-row justify-content-start mb-4">';
        
        foreach ($books as $book) {
            $prix = $book["prix"];
            $reduction = $book["reduction"];
            $prix_avec_reduction = number_format(($prix * (1 - $reduction * 0.01)), 2);
    ?>
            <div class="col-book">
                <div class="product h-100">
                    <figure class="product-media" style="background-color: white;">
                        <a href="product.php?isbn=<?php echo $book['ISBN']; ?>" style="background-color: white;">
                            <img src="<?php echo $book["img_livre"]; ?>" alt="Product image" class="product-image" style="background-color: white;">
                        </a>
                    </figure>

                    <div class="product-body d-flex flex-column">
                        <div class="product-cat">
                            by <a href="#"><?php echo $book["prenom_auteur"] . " " . $book["nom_auteur"]; ?></a>
                        </div>
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

                        <div class="product-footer mt-auto">
                            <div class="ratings-container">
                                <div class="ratings">
                                    <div class="ratings-val" style="width: <?php echo ceil($book['rating_client']) * 100 / 5; ?>%;"></div>
                                </div>
                                <span class="ratings-text">( <?php echo $book['nmbr_vote']; ?> Reviews )</span>
                            </div>

                            <?php if ($connecter) { ?>
                                <div class="product-action">
                                    <a class="btn-product btn-cart" onclick="addToCart('<?php echo $book['ISBN']; ?>')"><span>Add to cart</span></a>
                                    <a class="btn-product btn-wishlist" onclick="addToWishlist('<?php echo $book['ISBN']; ?>')"><span>Add to Wishlist</span></a>
                                </div>
                            <?php } else { ?>
                                <div class="product-action">
                                    <a class="btn-product btn-cart" href="connexion/login.php"><span>Add to cart</span></a>
                                    <a class="btn-product btn-wishlist" href="connexion/login.php"><span>Add to Wishlist</span></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
    <?php
        }
        
        // Si la rangée n'est pas complète (moins de 5 livres), ajouter des cases vides
        $empty_slots = 5 - count($books);
        for ($i = 0; $i < $empty_slots; $i++) {
            echo '<div class="col-book"></div>';
        }
        
        echo '</div>';
    
    // Fermeture de la connexion à la base de données
    $connexion->close();
    ?>
</div>

<style>
    /* Style pour assurer 5 colonnes égales */
    .book-row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -10px;
        margin-left: -10px;
    }
    
    .col-book {
        width: 20%;
        padding: 0 10px;
        box-sizing: border-box;
    }
    
    /* Style des cartes de livre */
    .product {
        transition: all 0.3s;
        border: 1px solid #ebebeb;
        border-radius: 5px;
        overflow: hidden;
        margin-bottom: 0;
        background-color: #fff;
        height: 100%;
    }
    
    .product figure {
        background-color: #fff;
    }
    
    .product-image {
        background-color: #fff;
    }
    
    .product:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
    }
    
    .product-image {
        height: 280px;
        object-fit: contain;
        padding: 10px;
        width: 100%;
    }
    
    .product-body {
        padding: 15px;
        height: 100%;
    }
    
    .product-title {
        font-size: 14px;
        margin-top: 10px;
        margin-bottom: 10px;
        height: 40px;
        overflow: hidden;
    }
    
    .product-price {
        font-size: 15px;
        margin-bottom: 15px;
    }
    
    .btn-product {
        font-size: 12px;
        padding: 5px 10px;
    }
    
    /* Responsive design */
    @media (max-width: 992px) {
        .col-book {
            width: 25%;
        }
        .col-book:nth-child(5) {
            display: none;
        }
    }
    
    @media (max-width: 768px) {
        .col-book {
            width: 33.333%;
        }
        .col-book:nth-child(4), 
        .col-book:nth-child(5) {
            display: none;
        }
    }
    
    @media (max-width: 576px) {
        .col-book {
            width: 50%;
        }
        .col-book:nth-child(3), 
        .col-book:nth-child(4), 
        .col-book:nth-child(5) {
            display: none;
        }
    }
</style>