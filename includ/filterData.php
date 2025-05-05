<?php
include(__DIR__.'/../connexion/connexion-DB.php');  // Adjust this path to your actual DB connection script

if (isset($_GET['type'])) {
    $type = $_GET['type'];
    switch ($type) {
        case 'categories':
            echo getCategories($connexion);
            break;
        case 'authors':
            echo getAuthors($connexion);
            break;
        case 'years':
            echo getYears($connexion);
            break;
        case 'languages':
            echo getLanguages($connexion);
            break;
        case 'prices':
            echo getPrices($connexion);
            break;
    }
}

function getCategories($conn) {
    $sql = "SELECT DISTINCT genre FROM livre";
    return generateCheckboxes($conn, $sql, 'genre', 'cat');
}

function getAuthors($conn) {
    $sql = "SELECT id_auteur, CONCAT(prenom_auteur, ' ', nom_auteur) AS name FROM auteur";
    $result = $conn->query($sql);
    $html = '';
    while ($row = $result->fetch_assoc()) {
        // Use `id_auteur` instead of name for the ID to be used in filters
        $html .= '<div class="filter-item"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="author-' . htmlspecialchars($row['id_auteur']) . '"><label class="custom-control-label" for="author-' . htmlspecialchars($row['id_auteur']) . '">' . htmlspecialchars($row['name']) . '</label></div></div>';
    }
    return $html;
}


function getYears($conn) {
    $sql = "SELECT DISTINCT YEAR(date_publication) as year FROM livre";
    return generateCheckboxes($conn, $sql, 'year', 'year');
}

function getLanguages($conn) {
    $sql = "SELECT DISTINCT langue FROM livre";
    return generateCheckboxes($conn, $sql, 'langue', 'lang');
}

function getPrices($conn) {
    $sql = "SELECT DISTINCT prix FROM livre ORDER BY prix";
    return generateCheckboxes($conn, $sql, 'prix', 'price');
}

function generateCheckboxes($conn, $sql, $field, $prefix) {
    $result = $conn->query($sql);
    $html = '';
    while ($row = $result->fetch_assoc()) {
        $id = $prefix === 'author' ? $row['id_auteur'] : htmlspecialchars($row[$field]);
        $label = $prefix === 'author' ? $row['name'] : htmlspecialchars($row[$field]);
        $html .= '<div class="filter-item"><div class="custom-control custom-checkbox"><input type="checkbox" class="custom-control-input" id="' . $prefix . '-' . $id . '"><label class="custom-control-label" for="' . $prefix . '-' . $id . '">' . $label . '</label></div></div>';
    }
    return $html;
}

?>