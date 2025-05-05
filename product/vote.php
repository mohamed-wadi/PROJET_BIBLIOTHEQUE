<?php
session_start();
include("../connexion/connexion-DB.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['isbn']) && isset($_POST['type']) && isset($_POST['IdComent'])) {
    $isbn = $_POST['isbn'];
    $type = $_POST['type'];
    $IdComent = $_POST['IdComent'];
    $IdClient = $_SESSION['id_client'];

    // Vérifier si le client a déjà voté pour ce commentaire
    $checkVoteQuery = "SELECT * FROM vote_commentaire WHERE id_commentaire = '$IdComent' AND id_client = '$IdClient'";
    $checkVoteResult = $connexion->query($checkVoteQuery);

    if ($checkVoteResult->num_rows > 0) {
        // Le client a déjà voté pour ce commentaire
        $voteData = $checkVoteResult->fetch_assoc();

        if ($type == "Helpful") {
            if ($voteData['Helpful'] > 0) {
                // Le client a déjà voté "Helpful", supprimer le vote précédent
                $updateQuery = "UPDATE commentaire SET Helpful = Helpful - 1 WHERE id_commentaire='$IdComent'";
                $deleteVoteQuery = "DELETE FROM vote_commentaire WHERE id_commentaire = '$IdComent' AND id_client = '$IdClient'";
            } else {
                // Le client a voté "Unhelpful", supprimer le vote précédent, décrémenter "Unhelpful" et incrémenter "Helpful"
                $updateQuery = "UPDATE commentaire SET Helpful = Helpful + 1, Unhelpful = Unhelpful - 1 WHERE id_commentaire='$IdComent'";
                $updateVoteQuery = "UPDATE vote_commentaire SET Helpful = 1, Unhelpful = 0 WHERE id_commentaire = '$IdComent' AND id_client = '$IdClient'";
            }
        } else { // Le type de vote est "Unhelpful"
            if ($voteData['Unhelpful'] > 0) {
                // Le client a déjà voté "Unhelpful", supprimer le vote précédent
                $updateQuery = "UPDATE commentaire SET Unhelpful = Unhelpful - 1 WHERE id_commentaire='$IdComent'";
                $deleteVoteQuery = "DELETE FROM vote_commentaire WHERE id_commentaire = '$IdComent' AND id_client = '$IdClient'";
            } else {
                // Le client a voté "Helpful", supprimer le vote précédent, décrémenter "Helpful" et incrémenter "Unhelpful"
                $updateQuery = "UPDATE commentaire SET Unhelpful = Unhelpful + 1, Helpful = Helpful - 1 WHERE id_commentaire='$IdComent'";
                $updateVoteQuery = "UPDATE vote_commentaire SET Unhelpful = 1, Helpful = 0 WHERE id_commentaire = '$IdComent' AND id_client = '$IdClient'";
            }
        }

        // Exécuter les requêtes
        $updateResult = $connexion->query($updateQuery);
        if(isset($deleteVoteQuery))
          $deleteVoteResult = $connexion->query($deleteVoteQuery);
        if(isset($updateVoteQuery))
          $updateVoteResult = $connexion->query($updateVoteQuery);

        if (($updateResult && isset($deleteVoteResult)) || ($updateResult && isset($updateVoteResult))) {
            echo json_encode(array("message" => "Vote mis à jour avec succès"));
        } else {
            echo json_encode(array("error" => "Erreur lors de la mise à jour du vote"));
        }
    } else {
        // Le client n'a pas encore voté pour ce commentaire, effectuer le vote normalement
        $updateQuery = "UPDATE commentaire SET $type = 1 WHERE id_commentaire='$IdComent'";
        $updateVoteQuery = "INSERT INTO vote_commentaire (id_commentaire, id_client, $type) VALUES ('$IdComent', '$IdClient', 1)";

        // Exécuter les requêtes
        $updateResult = $connexion->query($updateQuery);
        $updateVoteResult = $connexion->query($updateVoteQuery);

        if ($updateResult && $updateVoteResult) {
            echo json_encode(array("message" => "Vote enregistré avec succès"));
        } else {
            echo json_encode(array("error" => "Erreur lors de l'enregistrement du vote"));
        }
    }
} else {
    echo json_encode(array("error" => "Paramètres manquants"));
}
