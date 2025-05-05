<?php
session_start();
include("connexion/connexion-DB.php");

if (isset($_SESSION['id_client']) && isset($_POST['ISBN'])) {
    $id_client = $_SESSION['id_client'];
    $ISBN = $_POST['ISBN'];

    $query = "DELETE FROM wishlist WHERE id_client = $id_client AND ISBN = $ISBN";
    $result = mysqli_query($connexion, $query);

    if ($result) {
        echo "Le livre a été supprimé de votre wishlist.";
    } else {
        echo "Une erreur s'est produite lors de la suppression du livre de votre wishlist.";
    }
} else {
    echo "Erreur : Veuillez vous connecter pour supprimer un livre de votre wishlist.";
}
