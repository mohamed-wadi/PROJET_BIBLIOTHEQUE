<?php
session_start();
include("../connexion/connexion-DB.php");

$connecter = false;
if (isset($_SESSION['id_client'])) {
    $connecter = true;
    if ($_SESSION['role'] == "client") {
        header("location:../index.php");
    } else {
        $nom = $_SESSION['nom_client'];
        $prenom = $_SESSION['prenom_client'];
        $role = $_SESSION['role'];
        $valid = 1;
    }
} else {
    header("location:../404.php");
}