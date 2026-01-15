<?php
/**
 * Configuration de la base de données
 */
namespace App\config;

// use App\config\config;
// database config
define('DB_HOST', 'localhost');
define('DB_NAME', 'AppJobDating');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Session
// Configuration des sessions sécurisées
ini_set('session.cookie_httponly', 1);
ini_set('session.use_only_cookies', 1);
ini_set('session.cookie_secure', 0); // Mettre à 1 si HTTPS
ini_set('session.cookie_samesite', 'Strict');

// Durée de vie de la session (3h)
ini_set('session.gc_maxlifetime', 3600*3);
session_set_cookie_params(3600*3);

// Démarrage de la session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Régénération de l'ID de session pour prévenir le session hijacking
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}