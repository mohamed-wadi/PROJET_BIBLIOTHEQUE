<?php
include("connexion/connexion-DB.php");

// Requête SQL pour obtenir les 10 premiers livres les plus achetés
$sql = "SELECT l.ISBN,l.img_livre,a.prenom_auteur, a.nom_auteur, l.titre_livre, l.Paragraphe, l.prix,l.reduction
FROM livre l 
INNER JOIN auteur a ON l.id_auteur = a.id_auteur
GROUP BY l.ISBN
ORDER BY l.Date_added DESC
LIMIT 10;
";
$result = $connexion->query($sql);


?>


<div class="col-xl-8">
    <div class="block-wrapper ">
        <div class="owl-carousel carousel-equal-height owl-simple" data-toggle="owl" data-owl-options='{
                "nav": false, 
                "dots": true,
                "margin": 20,
                "loop": false,
                "responsive": {
                    "0": {
                        "items":2
                    },
                    "480": {
                        "items":2
                    },
                    "768": {
                        "items":3
                    },
                    "992": {
                        "items":4
                    },
                    "1200": {
                        "items":3
                    },
                    "1440": {
                        "items":4
                    }
                }
            }'>
            <?php
            // Vérification s'il y a des résultats
            if ($result->num_rows > 0) {
                // Affichage des données
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
            ?>
                    <div class="product">
                        <!-- <span class="product-label label-sale">Salee</span> -->
                        <figure class="product-media">
                            <a href="product.php?isbn=<?php echo $row['ISBN']; ?>">
                                <img src="<?php echo $row["img_livre"]; ?>" alt="Product image" class="product-image">
                            </a>
                        </figure><!-- End .product-media -->

                        <div class="product-body">
                            <div class="product-cat">
                                by <a href="#"><?php echo $row["prenom_auteur"] . " " . $row["nom_auteur"]; ?></a>
                            </div><!-- End .product-cat -->
                            <h3 class="product-title"><a href="product.php?isbn=<?php echo $row['ISBN']; ?>"><?php echo $row["titre_livre"]; ?></a></h3>
                            <!-- End .product-title -->
                            <?php
                            $prix = $row["prix"];
                            $reduction = $row["reduction"];
                            $prix_avec_reduction = number_format(($prix * (1 - $reduction * 0.01)), 2);
                            if ($row["reduction"] > 0) {
                                echo '<div class="product-price">
                        <span class="new-price">' . $prix_avec_reduction . ' $</span>
                        <span class="old-price">Was <s class=" text-danger">' . number_format($prix, 2)  . '</s> $</span>
                    </div><!-- End .product-price -->';
                            } else {
                                echo '<div class="product-price">
                            <span class="new-price">' . $prix . ' $</span>
                        </div><!-- End .product-price -->';
                            }
                            ?>



                            <div class="product-footer">
                                <div class="ratings-container">
                                    <div class="ratings">
                                        <div class="ratings-val" style="width: <?php echo ceil($row["rating_client"]) * 100 / 5; ?>%;"></div>
                                    </div><!-- End .ratings -->
                                    <span class="ratings-text">( <?php echo $row["nmbr_vote"]; ?> Reviews )</span>
                                </div><!-- End .rating-container -->

                                <?php if ($connecter) { ?>

                                    <div class="product-action">
                                        <a class="btn-product btn-cart" onclick="addToCart('<?php echo $row['ISBN']; ?>')"><span>Add to
                                                cart</span></a>
                                        <a class="btn-product btn-wishlist" onclick="addToWishlist('<?php echo $row['ISBN']; ?>')"><span>Add
                                                to Wishlist</span></a>
                                    </div><!-- End .product-action -->

                                <?php } else {  ?>

                                    <div class="product-action">
                                        <a class="btn-product btn-cart" href="connexion/login.php"><span>Add to cart</span></a>
                                        <a class="btn-product btn-wishlist" href="connexion/login.php"><span>Add to Wishlist</span></a>
                                    </div><!-- End .product-action -->

                                <?php }  ?>

                            </div><!-- End .product-footer -->
                        </div><!-- End .product-body -->
                    </div><!-- End .product -->
            <?php
                }
            }

            // Fermeture de la connexion à la base de données
            $connexion->close();
            ?>
        </div><!-- End .owl-carousel -->
    </div><!-- End .block-wrapper -->
</div><!-- End .col-lg-8 -->