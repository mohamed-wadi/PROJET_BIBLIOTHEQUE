<?php
session_start();
include("connexion/connexion-DB.php");

if (isset($_SESSION['id_client'])) {
    $id_client = $_SESSION['id_client'];

    $query = "SELECT livre.ISBN, livre.titre_livre, livre.prix, livre.img_livre
              FROM wishlist
              INNER JOIN livre ON wishlist.ISBN = livre.ISBN
              WHERE wishlist.id_client = $id_client";
    $result = mysqli_query($connexion, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>';
            echo '<td class="product-col">';
            echo '<div class="product">';
            echo '<figure class="product-media">';
            echo '<a href="#"><img src="' . $row['img_livre'] . '" alt="Product image"></a>';
            echo '</figure>';
            echo '<h3 class="product-title"><a href="#">' . $row['titre_livre'] . '</a></h3>';
            echo '</div>';
            echo '</td>';
            echo '<td class="price-col">$' . $row['prix'] . '</td>';
            echo '<td class="stock-col"><span class="in-stock">In stock</span></td>';
            echo '<td class="action-col">';
            echo '<button class="btn btn-block btn-outline-primary-2" onclick="addToCart1(' . $row['ISBN'] . ')"><i class="icon-cart-plus"></i>Add to Cart</button>';
            echo '</td>';
            echo '<td class="remove-col">';
            echo '<button class="btn-remove" onclick="removeFromWishlist(' . $row['ISBN'] . ')"><i class="icon-close"></i></button>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5">Votre wishlist est vide.</td></tr>';
    }
} else {
    echo '<tr><td colspan="5">Veuillez vous connecter pour afficher votre wishlist.</td></tr>';
}

