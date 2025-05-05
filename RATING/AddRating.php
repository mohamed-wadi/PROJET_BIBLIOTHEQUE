<?php
session_start();
include('../connexion/connexion-DB.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['ISBN']) && isset($_POST['rating_data'])) {
    // Assigner les valeurs des paramètres
    $ISBN = $_POST['ISBN'];
    $id_client = $_SESSION['id_client'];
    $rating_data = $_POST['rating_data'];

    // Prépare la déclaration SQL pour l'insertion
    $stmt = $connexion->prepare("INSERT INTO book_review (ISBN, id_client, rating_client) VALUES (?, ?, ?)");
    $stmt->bind_param("iii", $ISBN, $id_client, $rating_data);

    // Exécuter la déclaration préparée
    if ($stmt->execute() === TRUE) {
        $response = "Review added successfully!";
    } else {
        $response = "Error: " . $stmt . "<br>" . $connexion->error;
    }

    // Fermer la connexion à la base de données
    $stmt->close();
    $connexion->close();

    echo json_encode($response);
}
