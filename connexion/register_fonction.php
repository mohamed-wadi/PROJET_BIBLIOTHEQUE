<?php

include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom_client = $_POST['nom_client'];
    $prenom_client = $_POST['prenom_client'];
    $date_naissance = $_POST['date_naissance'];
    $genre = $_POST['genre'];
    $country = $_POST['country'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $mdp = $_POST['MDP'];
    $date_inscription = date("Y-m-d");
    $role = 'client';

    // Générez l'ID unique
    while (true) {
        $id_client = rand(10000000, 99999999);
        $query_check_ID = "SELECT * FROM client WHERE id_client = '$id_client'";
        $result_check_ID = mysqli_query($connexion, $query_check_ID);

        if (mysqli_num_rows($result_check_ID) === 0) {
            // L'ID est unique, sortir de la boucle
            break;
        }
    }

    // Requête préparée pour l'insertion
    $query_insert_user = "INSERT INTO client (nom_client,prenom_client,date_naissance,genre,country,phone,Email,MDP,Date_inscription,id_client,role) VALUES ('$nom_client','$prenom_client','$date_naissance','$genre','$country','$phone','$email','$mdp','$date_inscription','$id_client','$role')";

    $execute = mysqli_query($connexion, $query_insert_user);

    if ($execute) {
        session_start();
        $_SESSION['id_client'] = $id_client;
        $_SESSION['nom_client'] = $nom_client;
        $_SESSION['prenom_client'] = $prenom_client;
        $_SESSION['role'] = $role;

        // Répondre avec un JSON indiquant le succès
        echo json_encode(array('success' => true));
        exit();
    } else {
        // Répondre avec un JSON indiquant l'échec
        echo json_encode(array('success' => false, 'message' => 'Error inserting into database.'));
        exit();
    }
}
