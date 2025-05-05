<?php
session_start();
include("connexion/connexion-DB.php");

$connecter = false;
$pagesAutoriseesClient = array("index.php", "category-4cols.php", "about.php", "contact.php", "faq.php", "product.php","verification_email.php");

$pagesAutoriseesAdmin = array("dashboard.php", "../ADMIN_PAGES/index_admin.php", "../ADMIN_PAGES/request.php", "../ADMIN_PAGES/users.php", "../ADMIN_PAGES/book_add.php", "../ADMIN_PAGES/book_edit.php", "../ADMIN_PAGES/book_delete.php", "../ADMIN_PAGES/Othor-Add.php", "../ADMIN_PAGES/Othor_Edit.php", "../ADMIN_PAGES/Othor_delete.php", "../ADMIN_PAGES/User-Add.php", "../ADMIN_PAGES/User_Edit.php", "../ADMIN_PAGES/User_delete.php");

// Récupérer le nom de la page actuelle
$currentPage = basename($_SERVER['PHP_SELF']);


if (isset($_SESSION['id_client'])) {
    $connecter = true;
    if ($_SESSION['role'] == "admin" && !in_array($currentPage, $pagesAutoriseesAdmin)) {
        header("location:index_admin.php");
        exit;
    }
} else {
    if (!$connecter && !in_array($currentPage, $pagesAutoriseesClient)) {
        header("location:404.php");
        exit;
    }
}
