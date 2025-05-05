<?php
session_start();
include('connexion/connexion-DB.php');

if (isset($_POST['isbn'])) {
    $isbn = $_POST['isbn'];

    $sql = "DELETE FROM shoppingcart WHERE ISBN  = ? AND id_client = ?";
    $stmt = $connexion->prepare($sql);
    $stmt->bind_param("ii", $isbn, $_SESSION['id_client']); // Utilisation de "ii" pour deux entiers (cart_id et id_client)
    $stmt->execute();
    $stmt->close();
    $connexion->close();

    echo "L'article a été supprimé du panier avec succès.";
} else {
    echo 'Erreur : Aucun élément à supprimer spécifié.';
}
