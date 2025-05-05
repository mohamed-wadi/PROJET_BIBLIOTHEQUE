<?php
$serveur = "localhost";
$utilisateur = "root";
$mot_de_passe = "";
$base_de_donnees = "shm";

try {
    $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);
    if ($connexion->connect_error) {
        throw new Exception("La connexion a échoué : " . $connexion->connect_error);
    }
} catch (Exception $e) {
    session_start();
    $_SESSION['erreur']=$e->getMessage();
    header('location:404.html');
}
