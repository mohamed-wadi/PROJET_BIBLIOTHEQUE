
function loadComments(isbn) {
    $.ajax({
        url: 'product/AfficheComment.php',
        method: 'GET',
        data: { isbn: isbn },
        success: function (response) {
            $('#ListComment').html(response);
        }
    });
}

function Helpful(isbn, IdComent) {
    $.ajax({
        url: 'product/Vote.php',
        method: 'POST',
        data: { isbn: isbn, IdComent: IdComent, type: 'helpful' },
        success: function (response) {
            loadComments(isbn);
        }
    });
}

function Unhelpful(isbn, IdComent) {
    $.ajax({
        url: 'product/Vote.php',
        method: 'POST',
        data: { isbn: isbn, IdComent: IdComent, type: 'unhelpful' },
        success: function (response) {
            loadComments(isbn);
        }
    });
}

