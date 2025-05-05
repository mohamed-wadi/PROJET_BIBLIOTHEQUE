<?php

include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Email = $_POST['Email'];

    $query_check_email = "SELECT * FROM client WHERE Email = '$Email'";
    $result_check_email = mysqli_query($connexion, $query_check_email);

    if (mysqli_num_rows($result_check_email) > 0) {
        $response = array(
            'error' => true
        );
    } else {
        $response = array(
            'error' => false
        );
    }
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}