<?php
include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Récupérer les données du formulaire
    $Email = mysqli_real_escape_string($connexion, $_POST['Email']);
    $MDP = mysqli_real_escape_string($connexion, $_POST['MDP']);

    loginUser($connexion, $Email, $MDP);
}

function loginUser($connexion, $Email, $MDP) {
    $query_check_user = "SELECT * FROM client WHERE Email = '$Email'";
    $result_check_user = mysqli_query($connexion, $query_check_user);

    if (mysqli_num_rows($result_check_user) > 0) {
        $row = mysqli_fetch_assoc($result_check_user);

        if ($MDP == $row['MDP']) {
            session_start();
            $_SESSION['id_client'] = $row['id_client'];
            $_SESSION['nom_client'] = $row['nom_client'];
            $_SESSION['prenom_client'] = $row['prenom_client'];
            $_SESSION['role'] = $row['role'];

            echo json_encode(array(
                'error' => false,
                'redirectUrl' => ($row['role'] == "client") ? "../index.php" : "../ADMIN_PAGES/index_admin.php"
            ));
            exit();
        } else {
            echo json_encode(array(
                'error' => "password",
                'message' => 'Incorrect password'
            ));
            exit();
        }
    } else {
        echo json_encode(array(
            'error' => "email",
            'message' => 'No account associated with this email.'
        ));
        exit();
    }
}
