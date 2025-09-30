<?php
session_start();

// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_NAME', 'boutique_digitale');
define('DB_USER', 'root');
define('DB_PASS', '');

// Connexion à la base de données
try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}

// Fonction pour obtenir la salutation selon l'heure
function getSalutation() {
    $heure = date('H');
    if ($heure >= 5 && $heure < 12) {
        return "Bonjour";
    } elseif ($heure >= 12 && $heure < 18) {
        return "Bon après-midi";
    } else {
        return "Bonsoir";
    }
}

// Fonction pour valider l'email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL);
}

// Fonction pour hacher le mot de passe
function hashPassword($password) {
    return password_hash($password, PASSWORD_DEFAULT);
}

// Fonction pour vérifier le mot de passe
function verifyPassword($password, $hash) {
    return password_verify($password, $hash);
}
?>