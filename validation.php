<?php

include ('connexion/test_connexion.php');

// Check if the user is logged in and the validation parameter is set
if (isset($_SESSION['id_client']) && isset($_GET['validation']) && $_GET['validation'] == true) {
    $userId = $_SESSION['id_client'];

    // Fetch the user's purchases from the shoppingcart table
    $fetchCartSql = "SELECT * FROM shoppingcart WHERE id_client = ?";
    $fetchCartStmt = $connexion->prepare($fetchCartSql);
    $fetchCartStmt->bind_param("i", $userId);
    $fetchCartStmt->execute();
    $cartResult = $fetchCartStmt->get_result();

    if ($cartResult->num_rows > 0) {
        // Prepare statements for inserting into the buy table and deleting from the shopping cart
        $insertBuySql = "INSERT INTO buy (id_client,ISBN,price) VALUES (?,?,?)";
        $deleteCartSql = "DELETE FROM shoppingcart WHERE id_client = ? AND ISBN = ?";
        $insertBuyStmt = $connexion->prepare($insertBuySql);
        $deleteCartStmt = $connexion->prepare($deleteCartSql);

        // Loop through each item in the shopping cart
        while ($cartItem = $cartResult->fetch_assoc()) {
            $isbn = $cartItem['ISBN'];
            $price=$cartItem['price'];

            // Insert purchased item into the buy table
            $insertBuyStmt->bind_param("iii", $userId, $isbn,$price);
            $insertBuyStmt->execute();

            // Remove purchased item from the shopping cart
            $deleteCartStmt->bind_param("ii", $userId, $isbn);
            $deleteCartStmt->execute();
        }

        // Close the prepared statements
        $insertBuyStmt->close();
        $deleteCartStmt->close();
    }

    // Close the prepared statement for fetching the shopping cart
    $fetchCartStmt->close();

    // Redirect to checkout_valide.php after processing
    header("Location: checkout_valide.php");
    exit();
} else {
    // Redirect to login.php if conditions are not met
    header("Location: login.php");
    exit();
}
