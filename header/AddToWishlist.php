<?php
session_start();
include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    // Vérifier d'abord si le livre est déjà dans la liste de souhaits pour ce client
    $checkQuery = "SELECT * FROM wishlist WHERE id_client = '" . $_SESSION["id_client"] . "' AND ISBN = '$isbn'";
    $checkResult = $connexion->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Le livre est déjà dans la liste de souhaits pour ce client
        echo json_encode(array("message" => "The book is already on the wish list","icon" => 2));
    } else {
        // Le livre n'est pas encore dans la liste de souhaits pour ce client, procéder à l'ajout
        // Insérer le produit dans la liste de souhaits
        $requeteAddToWishlist = "INSERT INTO wishlist (id_client, ISBN) VALUES ('" . $_SESSION["id_client"] . "', '$isbn')";
        $resultAddToWishlist = $connexion->query($requeteAddToWishlist);

        if ($resultAddToWishlist) {
            echo json_encode(array("message" => "Book successfully added to wishlist","icon" => 1));
        } else {
            echo json_encode(array("message" => "Error adding book to wishlist","icon" => 2));
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $id_client = $_SESSION["id_client"];
    $id_client = mysqli_real_escape_string($connexion, $id_client);

    $sql = "SELECT count(wishlist_id) as NLR 
        FROM wishlist 
        WHERE id_client = $id_client";
    $result = $connexion->query($sql);

    if ($result) {
        $data = array();
        $row = $result->fetch_assoc();
        $data['sql'] = $row;
        echo json_encode($data);
    } else {
        echo json_encode(array("error" => "Erreur lors de l'exécution de la requête : " . $connexion->error));
    }
}
