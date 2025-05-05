
<?php
session_start();
include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isbn'])) {
    $message = '';
    $test = 0;
    // Récupérer l'ISBN du produit envoyé via AJAX
    $isbn = $_POST['isbn'];

    // Vérifier d'abord si le livre est déjà dans le panier pour ce client
    $checkQuery = "SELECT * FROM shoppingcart WHERE id_client = '" . $_SESSION["id_client"] . "' AND ISBN = '$isbn'";
    $checkResult = $connexion->query($checkQuery);

    if ($checkResult->num_rows > 0) {
        // Le livre est déjà dans le panier pour ce client
        echo json_encode(array("message" => "The book is already in the cart","icon" => 2));
    } else {
        // Exécuter la requête pour récupérer le prix et la réduction du livre
        $query = "SELECT prix, reduction FROM livre WHERE ISBN = $isbn";
        $result = $connexion->query($query);

        if ($result) {
            // Vérifier si le livre existe dans la base de données
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $prix = $row["prix"];
                $reduction = $row["reduction"];

                // Calculer le prix avec réduction
                if ($prix > 0 && $reduction > 0) {
                    $price = $prix * (1 - $reduction / 100);
                } else {
                    $price = $prix;
                }

                // Insérer le produit dans le panier
                $requeteAddToCart = "INSERT INTO shoppingcart (id_client,ISBN,price) VALUES ('" . $_SESSION["id_client"] . "', '$isbn', '$price')";
                $resultAddToCart = $connexion->query($requeteAddToCart);

                if ($resultAddToCart) {
                    echo json_encode(array("message" => "Book successfully added to cart","icon" => 1));
                } else {
                    echo json_encode(array("message" => "Error adding product to cart","icon" => 2));
                }
            } else {
                echo json_encode(array("message" => "Delivered $isbn does not exist in the database","icon" => 2));
            }
        } else {
            echo json_encode(array("message" => "Error executing query : " . $connexion->error,"icon" => 2));
        }
    }
    // Fermez la connexion à la base de données si nécessaire
    $connexion->close();
}
if ($_SERVER['REQUEST_METHOD'] == 'GET') {

    $id_client = $_SESSION["id_client"];
    $id_client = mysqli_real_escape_string($connexion, $id_client);

    $CartCount = "SELECT count(cart_id) as NLR 
        FROM shoppingcart 
        WHERE id_client = $id_client";

    $result = $connexion->query($CartCount);

    if ($result) {
        $data = array();

        // Récupérer les résultats de la première requête
        $row1 = $result->fetch_assoc();
        $data['CartCount'] = $row1['NLR'];

        echo json_encode($data);
    } else {
        echo json_encode(array("error" => "Erreur lors de l'exécution de la requête : " . $connexion->error));
    }

    $connexion->close();
}
