<?php
include('Mobile_Detect.php');
include('BrowserDetection.php');


// Fonction pour obtenir l'adresse IP du visiteur
function getVisitorIP()
{
    return $_SERVER['REMOTE_ADDR'];
    // $ip = '105.158.172.31';
    // return $ip;
}


// Fonction pour obtenir le pays à partir de l'adresse IP en utilisant l'API ipinfo.io

function getCountryByIP($ip)
{
    $url = "https://ipinfo.io/$ip/json";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);

    if ($response === FALSE) {
        die('Erreur lors de la récupération des données de l\'API.');
    }

    $data = json_decode($response, true);

    if (isset($data['error']) && $data['error']['title'] === 'Wrong ip') {
        return "Adresse IP incorrecte";
    } elseif (isset($data['country'])) {
        return $data['country'];
    } else {
        return "Pays inconnu";
    }

    // curl_close($ch);
}



// Fonction pour insérer les informations du visiteur dans la base de données
function insertVisitorData($connexion, $browser_name, $browser_version, $type, $os, $url, $country, $ref)
{
    $sql = "INSERT INTO visitor(browser_name,browser_version,type,os,url,country,ref) VALUES ('$browser_name','$browser_version','$type','$os','$url','$country','$ref')";
    mysqli_query($connexion, $sql);
}

// Fonction pour détecter le type de périphérique (Mobile, Tablet, PC)
function detectDeviceType()
{
    $detect = new Mobile_Detect();

    if ($detect->isMobile()) {
        return 'Mobile';
    } elseif ($detect->isTablet()) {
        return 'Tablet';
    } else {
        return 'PC';
    }
}

// Fonction pour détecter le système d'exploitation (iOS, Android, Windows)
function detectOS()
{
    $detect = new Mobile_Detect();

    if ($detect->isiOS()) {
        return 'iOS';
    } elseif ($detect->isAndroidOS()) {
        return 'Android';
    } else {
        return 'Windows';
    }
}

// Obtenez l'adresse IP du visiteur
$visitorIP = getVisitorIP();

// Obtenez le pays à partir de l'adresse IP
$country = getCountryByIP('105.158.172.31');

// Créez une instance de la classe BrowserDetection
$browser = new Wolfcast\BrowserDetection;
$browser_name = $browser->getName();
$browser_version = $browser->getVersion();

// Détectez le type de périphérique
$type = detectDeviceType();

// Détectez le système d'exploitation
$os = detectOS();

// Obtenez l'URL et le référent
$url = (isset($_SERVER['HTTPS'])) ? "https" : "http" . "://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';

// Insérez les informations du visiteur dans la base de données
insertVisitorData($connexion, $browser_name, $browser_version, $type, $os, $url, $country, $ref);
?>