<?php
session_start();
include('connexion/connexion-DB.php');

if (isset($_SESSION['id_client'])) {
    $cartItems = [];
    $sql = "SELECT s.*, l.titre_livre, l.img_livre, l.prix
            FROM shoppingcart s
            JOIN livre l ON s.ISBN = l.ISBN
            WHERE id_client = ?";

    // Préparez la requête
    $stmt = $connexion->prepare($sql);

    // Liez le paramètre
    $stmt->bind_param("i", $_SESSION['id_client']);

    // Exécutez la requête
    $stmt->execute();

    // Récupérez le résultat
    $result = $stmt->get_result();

    // Si des lignes sont retournées, les ajouter à $cartItems
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $cartItems[] = $row;
        }
    }

    // Retourner les éléments du panier au format JSON
    echo json_encode($cartItems);
} else {
    // Si l'utilisateur n'est pas connecté, renvoyer un message d'erreur
    echo json_encode(['error' => 'User not logged in']);
}
