<?php

include ('connexion/test_connexion.php');

if(isset($_GET['ISBN'])) {
    // Récupérez le nom du fichier associé à l'ISBN dans votre base de données
    // Supposons que vous avez une table "livre" avec une colonne "Emplacement" contenant le nom du fichier à télécharger
    $isbn = $_GET['ISBN'];
    
    // Requête SQL pour obtenir le nom du fichier à partir de la base de données
    $fetchFileNameSql = "SELECT Emplacement FROM livre WHERE ISBN = ?";
    $fetchFileNameStmt = $connexion->prepare($fetchFileNameSql);
    $fetchFileNameStmt->bind_param("i", $isbn);
    $fetchFileNameStmt->execute();
    $fetchFileNameStmt->bind_result($fileName);
    $fetchFileNameStmt->fetch();
    $fetchFileNameStmt->close();

    // Chemin vers le répertoire où se trouvent les fichiers à télécharger
    $fileDir = "/Applications/XAMPP/xamppfiles/htdocs/PFA/"; // Chemin corrigé pour Mac

    // Chemin complet du fichier à télécharger
    $filePath = $fileDir . $fileName;

    // Vérifiez si le fichier existe
    if(file_exists($filePath)) {
        // Définissez les en-têtes pour forcer le téléchargement du fichier
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Content-Length: ' . filesize($filePath));

        // Lire le fichier et le sortir sur le flux de sortie
        readfile($filePath);
        exit;
    } else {
        // Fichier non trouvé, rediriger ou afficher un message d'erreur
        echo "Fichier non trouvé.";
    }
} else {
    // ISBN non spécifié, rediriger ou afficher un message d'erreur
    echo "ISBN non spécifié.";
}
