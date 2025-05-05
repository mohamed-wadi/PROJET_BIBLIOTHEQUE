<?php
// Fonction pour générer un mot de passe aléatoire contenant des lettres minuscules, majuscules et au moins un chiffre
function generatePassword($length = 10) {
    // Caractères autorisés dans le mot de passe
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers = '0123456789';
    $password = '';

    // Choisissez au hasard un chiffre pour inclure dans le mot de passe
    $password .= $numbers[rand(0, strlen($numbers) - 1)];

    // Génération du reste du mot de passe
    for ($i = 1; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }
    
    // Mélangez les caractères pour un mot de passe plus aléatoire
    $password = str_shuffle($password);
    
    return $password;
}

// Générer un mot de passe de 10 caractères
$password = generatePassword(10);

// Afficher le mot de passe généré
echo "Mot de passe généré automatiquement : " . $password;
