<?php
session_start();
include("../connexion/connexion-DB.php");

$connecter = false;
if (isset($_SESSION['id_client'])) {
    $connecter = true;
    if ($_SESSION['role'] == "admin") {
        header("location:index_admin.php");
    }
}

$isbn = $_GET['isbn'];
$query = "SELECT c.id_commentaire, c.commentaire, c.date_commentaire, c.Helpful, c.Unhelpful, COUNT(c.id_commentaire) AS nombre_commentaires, l.nom_client
    FROM CLIENT l
    JOIN commentaire c ON l.id_client = c.id_client
    WHERE c.ISBN = '$isbn'
    GROUP BY c.date_commentaire";

$resultsql = $connexion->query($query);

$output = '';

if ($connecter) {
    $output .= '<h3>Reviews (' . $resultsql->num_rows . ')</h3>';
}

while ($row = $resultsql->fetch_assoc()) {
    $date_commentaire = strtotime($row['date_commentaire']);
    $aujourdhui = strtotime(date('Y-m-d'));
    $difference_en_jours = ($aujourdhui - $date_commentaire) / (60 * 60 * 24);

    if ($difference_en_jours < 1) {
        $output_date = 'Added to days';
    } else if ($difference_en_jours < 7) {
        $output_date = intval($difference_en_jours) . ' days ago';
    } else {
        $output_date = date('Y/m/d', $date_commentaire);
    }

    $H = $row['Helpful'];
    $U = $row['Unhelpful'];
    if ($U == 0 && $H == 0) {
        $withd = 0;
    } else {
        $withd = ($H / ($U + $H)) * 100;
    }

    $output .= '
    <div class="review">
        <div class="row no-gutters">
            <div class="col-auto">
                <h4>' . $row['nom_client'] . '</h4>
                <div class="ratings-container">
                    <div class="ratings">
                        <div class="ratings-val" style="width: ' . $withd . '%;"></div>
                    </div>
                </div><!-- End .rating-container -->
                <span class="review-date">' . $output_date . '</span>
            </div><!-- End .col -->
            <div class="col">
                <div class="review-content">
                    <p>' . $row['commentaire'] . '</p>
                </div><!-- End .review-content -->';

    if ($connecter) {
        $output .= '<div class="review-action">
                        <a onclick="Helpful(' . $isbn . ',' . $row['id_commentaire'] . ')"><i class="icon-thumbs-up"></i>Helpful (' . $row['Helpful'] . ')</a>
                        <a onclick="Unhelpful(' . $isbn . ',' . $row['id_commentaire'] . ')"><i class="icon-thumbs-down"></i>Unhelpful (' . $row['Unhelpful'] . ')</a>
                    </div><!-- End .review-action -->';
    }

    $output .= '</div><!-- End .col-auto -->
        </div><!-- End .row -->
    </div><!-- End .review -->';
}
if ($connecter) {
    $output .= '<form id="frm-comment" style="margin-top: 50px;">
    <div class="form-group row" style="align-items: center;">
      <div class="col-sm-10">
        <textarea name="commentaire" id="commentaire" cols="30" rows="5" class="form-control form-control-sm"
          placeholder="Votre commentaire" required></textarea>
      </div>
      <div class="col-sm-2">
        <input type="hidden" name="isbn" id="isbn" value="' . $isbn . '">
        <input type="button" id="submitButton" value="SEND" class="btn btn-primary mb-2" />
      </div>
    </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#submitButton").click(function() {
                var str = $("#frm-comment").serialize() + "&comment=" + $("#commentaire").val();
    
                $.ajax({
                    url: "product/add_comment.php",
                    data: str,
                    type: "post",
                    success: function(response) {
                        var result = JSON.parse(response);
                        if (result.message) {
                            $("#commentaire").val("");
                            $("#isbn").val("");
                            loadComments(' . $isbn . ');
                        } else {
                            alert("Échec de l\'ajout du commentaire !");
                            return false;
                        }
                    }
                });
            });
        });
    </script>';
}

$output =
    '<div class="product-details-tab">
    <div class="tab-content">
        <div class="tab-pane active" id="product-review-tab" role="tabpanel" aria-labelledby="product-review-link">
            <div class="reviews">' . $output . '</div><!-- End .reviews -->
        </div><!-- .End .tab-pane -->
    </div><!-- End .tab-content -->
</div><!-- End .product-details-tab -->';

echo $output;