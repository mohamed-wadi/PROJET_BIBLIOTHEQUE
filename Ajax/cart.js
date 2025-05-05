$(document).ready(function () {
    loadCartItems();

    $(document).on('click', '.btn-remove', function () {
        var isbn = $(this).data('isbn');
        removeFromCart(isbn);
    });
});

function loadCartItems() {
    $.ajax({
        url: 'cart_ajax.php',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            $('#cart-body').empty();
            if (response.error) {
                console.log('Error:', response.error);
                return;
            }

            $.each(response, function (index, item) {
                var newRow = '<tr>' +
                    '<td class="product-col">' +
                    '<div class="product">' +
                    '<figure class="product-media">' +
                    '<a href="product.php?isbn=' + item.ISBN + '"><img src="' + item.img_livre + '" alt="Product image"></a>' +
                    '</figure>' +
                    '<h3 class="product-title"><a href="#">' + item.titre_livre + '</a></h3>' +
                    '</div>' +
                    '</td>' +
                    '<td class="price-col">$' + parseFloat(item.price).toFixed(2) + '</td>' +
                    '<td class="remove-col">' +
                    '<button type="button" class="btn-remove" data-isbn="' + item.ISBN + '"><i class="icon-close"></i></button>' +
                    '</td>' +
                    '</tr>';
                $('#cart-body').append(newRow);
            });

            // Calculer le total du panier
            calculateCartTotal(response);
            loadCartData();
        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
        }
    });
}

function calculateCartTotal(cartItems) {
    var total = 0;
    $.each(cartItems, function (index, item) {
        total += parseFloat(item.price);
    });
    $('#cart-total').text('$' + total.toFixed(2));
}

function removeFromCart(isbn) {
    $.ajax({
        url: 'remove_from_cart.php',
        type: 'POST',
        data: { isbn: isbn },
        success: function (response) {
            loadCartItems();
            loadCartData();
        },
        error: function (xhr, status, error) {
            console.log('Error:', error);
        }
    });
}

$(document).ready(function () {
    loadCartItems();
    loadCartData();
});