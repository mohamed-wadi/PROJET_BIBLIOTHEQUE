<?php
include('../connexion/connexion-DB.php');

if (isset($_POST["ISBN"])) {
    $ISBN = $_POST["ISBN"];
    $average_rating = 0;
    $total_review = 0;
    $five_star_review = 0;
    $four_star_review = 0;
    $three_star_review = 0;
    $two_star_review = 0;
    $one_star_review = 0;
    $total_user_rating = 0;

    $stmt = $connexion->prepare("SELECT * FROM book_review WHERE ISBN = ? ORDER BY review_id DESC");
    $stmt->bind_param("s", $ISBN);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {

        switch ($row["rating_client"]) {
            case 5:
                $five_star_review++;
                break;
            case 4:
                $four_star_review++;
                break;
            case 3:
                $three_star_review++;
                break;
            case 2:
                $two_star_review++;
                break;
            case 1:
                $one_star_review++;
                break;
            default:
                break;
        }

        $total_review++;
        $total_user_rating += $row["rating_client"];
    }

    if ($total_review > 0) {
        $average_rating = $total_user_rating / $total_review;
    }

    $output = array(
        'average_rating'    =>    number_format($average_rating, 1),
        'total_review'        =>    $total_review,
        'five_star_review'    =>    $five_star_review,
        'four_star_review'    =>    $four_star_review,
        'three_star_review'    =>    $three_star_review,
        'two_star_review'    =>    $two_star_review,
        'one_star_review'    =>    $one_star_review
    );

    echo json_encode($output);
}
