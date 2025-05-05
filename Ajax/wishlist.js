// Fonction pour charger la wishlist via AJAX
function loadWishlist() {
    $.ajax({
        url: 'load_wishlist.php',
        method: 'GET',
        success: function(response) {
            $('#wishlist-body').html(response);
            loadWishlistCount();
        }
    });
}

// Fonction pour supprimer un livre de la wishlist
function removeFromWishlist(ISBN) {
    $.ajax({
        url: 'remove_from_wishlist.php',
        method: 'POST',
        data: {ISBN: ISBN},
        success: function(response) {
            loadWishlist(); // Recharger la wishlist après la suppression
        }
    });
}

function addToCart1(ISBN) {
    addToCart(ISBN),
    removeFromWishlist(ISBN)
}

// Charger la wishlist lors du chargement de la page
$(document).ready(function() {
    loadWishlist();
    loadWishlistCount();
});
