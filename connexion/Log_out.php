<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id_client'])) {
    // Détruire toutes les données de la session
    session_unset();
    session_destroy();

    // Rediriger vers la page de connexion ou toute autre page après la déconnexion
    header("Location: login.php");
    exit();
} else {
    // Si l'utilisateur n'est pas connecté, rediriger vers la page d'accueil ou une autre page appropriée
    header("Location: index.php");
    exit();
}
?>
