<link rel="stylesheet" href="assets/css/fontawesome-free-6.5.1-web/css/all.css"/>
<style>
    .progress-label-left {
        float: left;
        margin-right: 0.5em;
        line-height: 1em;
    }

    .progress-label-right {
        float: right;
        margin-left: 0.3em;
        line-height: 1em;
    }

    .star-light {
        color: #e9ecef;
    }

    .ratings-container {
        display: flex;
        align-items: flex-start;
        font-size: 1.3rem;
        margin-bottom: 1.7rem;
        line-height: 1;
        white-space: nowrap;
    }

    .RAT {
        padding-left: 10px;
        padding-right: 10px;
    }
</style>

<div class="reviews">
    <div class="review">
        <div class="row no-gutters">
            <div class="col text-center">
                <h2 class="text-warning">
                    <b><span id="average_rating">0.0</span> / 5</b>
                </h2>

                <div class="mb-3">
                    <i class="fas fa-star star-light mr-1 main_star"></i>
                    <i class="fas fa-star star-light mr-1 main_star"></i>
                    <i class="fas fa-star star-light mr-1 main_star"></i>
                    <i class="fas fa-star star-light mr-1 main_star"></i>
                    <i class="fas fa-star star-light mr-1 main_star"></i>
                </div>
                <h3><span id="total_review">0</span> Review</h3>
            </div>
            <div class="col text-center RAT">

                <div>
                    <div class="progress-label-left">
                        <b>5</b>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="progress-label-right">(<span id="total_five_star_review">0</span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="five_star_progress"></div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div>
                    <div class="progress-label-left">
                        <b>4</b>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="progress-label-right">(<span id="total_four_star_review">0</span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="four_star_progress"></div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div>
                    <div class="progress-label-left">
                        <b>3</b>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="progress-label-right">(<span id="total_three_star_review">0</span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="three_star_progress"></div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div>
                    <div class="progress-label-left">
                        <b>2</b>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="progress-label-right">(<span id="total_two_star_review">0</span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="two_star_progress"></div>
                    </div>
                </div>
                <p>&nbsp;</p>
                <div>
                    <div class="progress-label-left">
                        <b>1</b>
                        <i class="fas fa-star text-warning"></i>
                    </div>
                    <div class="progress-label-right">(<span id="total_one_star_review">0</span>)</div>
                    <div class="progress">
                        <div class="progress-bar bg-warning" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" id="one_star_progress"></div>
                    </div>
                </div>
            </div>
            <div class="col text-center">
                <h3 class="mt-4 mb-3">Write Review Here</h3>
                <button type="button" name="add_review" id="add_review" class="btn btn-primary">Review</button>
            </div>
        </div><!-- End .row -->
    </div><!-- End .review -->
</div><!-- End .reviews -->

<div id="review_modal" class="modal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Submit Review</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="add_review_form">
                    <h4 class="text-center mt-2 mb-4">
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_1" data-rating="1"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_2" data-rating="2"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_3" data-rating="3"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_4" data-rating="4"></i>
                        <i class="fas fa-star star-light submit_star mr-1" id="submit_star_5" data-rating="5"></i>
                    </h4>
                    <div class="form-group text-center mt-4">
                        <input type="hidden" name="ISBN" value="<?php echo $_GET['isbn']; ?>">
                        <button type="button" class="btn btn-primary mt-3" id="save_review">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
<script>
    $(document).ready(function() {
        var rating_data = 0;
        var ISBN = "<?php echo $_GET['isbn']; ?>";
        load_rating_data(ISBN);

        $('#add_review').click(function() {
            $('#review_modal').modal('show');
        });

        $(document).on('mouseenter', '.submit_star', function() {
            var rating = $(this).data('rating');
            reset_background();

            for (var count = 1; count <= rating; count++) {
                $('#submit_star_' + count).addClass('text-warning');
            }
        });

        function reset_background() {
            for (var count = 1; count <= 5; count++) {
                $('#submit_star_' + count).addClass('star-light');
                $('#submit_star_' + count).removeClass('text-warning');
            }
        }

        $(document).on('mouseleave', '.submit_star', function() {
            reset_background();

            for (var count = 1; count <= rating_data; count++) {
                $('#submit_star_' + count).removeClass('star-light');
                $('#submit_star_' + count).addClass('text-warning');
            }
        });

        $(document).on('click', '.submit_star', function() {
            rating_data = $(this).data('rating');
        });

        $(document).ready(function() {
            $('#save_review').click(function() {
                $.ajax({
                    type: 'POST',
                    url: 'RATING/AddRating.php', // Chemin vers votre script PHP
                    data: {
                        ISBN: ISBN,
                        rating_data: rating_data
                    },
                    success: function(response) {
                        $('#review_modal').modal('hide');

                        load_rating_data();

                        //alert(data);
                    }
                });
            });
        });

        function load_rating_data() {
            $.ajax({
                url: "RATING/AfficheRating.php",
                method: "POST",
                data: {
                    ISBN: ISBN
                },
                dataType: "JSON",
                success: function(data) {

                    // $('#ratings_val').css('width', data.average_rating * 10 + '%');
                    $('#ratings_val').css('width', Math.ceil(data.average_rating) * 100 / 5 + '%');
                    $('#total_review1').text(data.total_review);

                    $('#average_rating').text(data.average_rating);
                    $('#total_review').text(data.total_review);


                    var count_star = 0;

                    $('.main_star').each(function() {
                        count_star++;
                        if (Math.ceil(data.average_rating) >= count_star) {
                            $(this).addClass('text-warning');
                            $(this).addClass('star-light');
                        }
                    });

                    $('#total_five_star_review').text(data.five_star_review);
                    $('#total_four_star_review').text(data.four_star_review);
                    $('#total_three_star_review').text(data.three_star_review);
                    $('#total_two_star_review').text(data.two_star_review);
                    $('#total_one_star_review').text(data.one_star_review);

                    $('#five_star_progress').css('width', (data.five_star_review / data.total_review) * 100 + '%');
                    $('#four_star_progress').css('width', (data.four_star_review / data.total_review) * 100 + '%');
                    $('#three_star_progress').css('width', (data.three_star_review / data.total_review) * 100 + '%');
                    $('#two_star_progress').css('width', (data.two_star_review / data.total_review) * 100 + '%');
                    $('#one_star_progress').css('width', (data.one_star_review / data.total_review) * 100 + '%');


                }
            })
        }


        load_rating_data();
    });
</script>