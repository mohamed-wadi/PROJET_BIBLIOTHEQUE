<?php
session_start();
include("../connexion/connexion-DB.php");
include '../header/HeadHom.html';
include("../header/ScriptHom.html");

if (isset($_GET['isbn'])) {
	if (isset($_SESSION['id_client'])) {
		$clientId = $_SESSION['id_client'];
	}
	$isbn = $_GET['isbn'];
	$sql = "SELECT
        l.ISBN,
        l.titre_livre AS titre,
        l.img_livre AS img,
        l.Paragraphe,
        l.prix,
        l.langue,
        l.date_publication,
        l.genre,
        a.nom_auteur,
        a.prenom_auteur,
        COUNT(c.id_commentaire) AS nombre_commentaires
        FROM
            livre l
        JOIN auteur a ON
            l.id_auteur = a.id_auteur
        LEFT JOIN commentaire c ON
            l.ISBN = c.ISBN
        WHERE l.ISBN='$isbn'
        GROUP BY l.ISBN";

	$result = $connexion->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_assoc();
		// Calcul du pourcentage des avis
		$total_reviews = $row['nombre_commentaires'];
		$reviews_percentage = ($total_reviews > 0) ? round(($total_reviews / $total_reviews) * 100) : 0;
	} else {
		header("location:404.html");
		exit(); // Ajout de l'instruction exit pour arrêter l'exécution du script après la redirection.
	}
} else {
	header("location:404.html");
	exit();
}
?>

<style>
	@media screen and (min-width: 1280px) {
		.container {
			max-width: 1100px;
		}
	}
</style>

<div class="container quickView-container">
	<div class="quickView-content">
		<div class="page-content">
			<div class="container">
				<div class="product-details-top">
					<div class="row">
						<div class="col-md-4">
							<div class="product-gallery product-gallery-vertical">
								<img id="product-zoom" src="<?php echo '' . $row['img']; ?>" alt="product image">
							</div><!-- End .product-gallery -->
						</div><!-- End .col-md-6 -->

						<div class="col-md-8">
							<div class="product-details">
								<h1 class="product-title"><?php echo $row['titre']; ?></h1>
								<!-- End .product-title -->

								<div class="ratings-container">
									<div class="ratings">
										<div class="ratings-val" id="ratings_val"></div>
									</div>
									<a class="ratings-text">(<span id="total_review1">0</span> Reviews )</a>
								</div><!-- End .rating-container -->

								<div class="product-price">
									$<?php echo $row['prix']; ?>
								</div><!-- End .product-price -->

								<div class="product-content">
									<p>
									<h6>Author: <?php echo $row['nom_auteur'] . ' ' . $row['prenom_auteur']; ?></h6>
									</p>
								</div><!-- End .product-content -->

								<div class="product-content">
									<p>Language: <?php echo $row['langue']; ?></p>
								</div><!-- End .product-content-->

								<div class="product-content">
									<p> Date Published: <?php echo $row['date_publication']; ?> </p>
								</div><!-- End .product-content-->

								<div class="product-content">
									<p><?php echo $row['Paragraphe']; ?></p>
								</div><!-- End .product-content -->

								<div class="product-details-action">
									<a class="btn-product btn-cart" onclick="addToCart('<?php echo $row['ISBN']; ?>')"><span>add to
											cart</span></a>

									<div class="details-action-wrapper">
										<a class="btn-product btn-wishlist" title="Wishlist" onclick="addToWishlist('<?php echo $row['ISBN']; ?>')"><span>Add to
												Wishlist</span></a>
									</div><!-- End .details-action-wrapper -->
								</div><!-- End .product-details-action -->

								<div class="product-details-footer" id="product-details-footer">
									<div class="product-cat">
										<span>Genre:</span>
										<a href="#"><?php echo $row['genre']; ?></a>
									</div><!-- End .product-cat -->

									<div class="social-icons social-icons-sm ICO" style="margin-left: 0px;">
										<span class="social-label">Share:</span>
										<a href="#" class="social-icon" title="Facebook" target="_blank"><i class="icon-facebook-f"></i></a>
										<a href="#" class="social-icon" title="Twitter" target="_blank"><i class="icon-twitter"></i></a>
										<a href="#" class="social-icon" title="Instagram" target="_blank"><i class="icon-instagram"></i></a>
										<a href="#" class="social-icon" title="Pinterest" target="_blank"><i class="icon-pinterest"></i></a>
									</div>
								</div><!-- End .product-details-footer -->
							</div><!-- End .product-details -->
						</div><!-- End .col-md-6 -->
					</div><!-- End .row -->
				</div><!-- End .product-details-top -->
			</div><!-- End .container -->
		</div><!-- End .page-content -->
	</div>
</div>