<?php
session_start();
include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['comment']) && isset($_POST['isbn'])) {
    $commentaire = $_POST['comment'];
    $isbn = $_POST['isbn'];
    $idClient = $_SESSION['id_client'];

    // Vous devez insérer les données dans votre table de commentaires ici
    // Supposons que votre table de commentaires s'appelle "commentaire"
    $insertQuery = "INSERT INTO commentaire (id_client, ISBN, commentaire) VALUES ('$idClient', '$isbn', '$commentaire')";
    $insertResult = $connexion->query($insertQuery);

    if ($insertResult) {
        echo json_encode(array("message" => "Commentaire ajouté avec succès"));
    } else {
        echo json_encode(array("error" => "Erreur lors de l'ajout du commentaire"));
    }
} else {
    echo json_encode(array("error" => "Paramètres manquants"));
}
