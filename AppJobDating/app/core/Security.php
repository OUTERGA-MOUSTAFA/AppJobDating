<?php

namespace App\app\core;

class Security
{
    /**
     * Génère un token CSRF
     */
    
    public function generateCsrfToken(): string
    {
        if (!Session::getInstance()->has('_csrf_token')) {
            $token = bin2hex(random_bytes(32));
            Session::getInstance()->set('_csrf_token', $token);
        }

        return Session::getInstance()->get('_csrf_token');
    }

    /**
     * Vérifie le token CSRF
     */

    public function verifyCsrfToken(string $token): bool
    {
        $sessionToken = Session::getInstance()->get('_csrf_token');
        
        if (!$sessionToken || !$token) {
            return false;
        }

        return hash_equals($sessionToken, $token);
    }

    /**
     * Nettoie les données contre XSS
     */
    public function sanitize($data)
    {
        if (is_array($data)) {
            return array_map([$this, 'sanitize'], $data);
        }

        return htmlspecialchars(strip_tags($data), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Valide et nettoie une email
     */

    public function sanitizeEmail(string $email): string
    {
        return filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     * Valide une URL
     */

    public function sanitizeUrl(string $url): string
    {
        return filter_var($url, FILTER_SANITIZE_URL);
    }

    /**
     * Hash un mot de passe de manière sécurisée
     */

    public function hashPassword(string $password): string
    {
        return password_hash($password, PASSWORD_ARGON2ID);
    }

    /**
     * Vérifie un mot de passe
     */

    public function verifyPassword(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    /**
     * Génère un token aléatoire sécurisé
     */

    public function generateToken(int $length = 32): string
    {
        return bin2hex(random_bytes($length));
    }

    /**
     * Protège contre les injections SQL (à utiliser avec PDO)
     */
    public function escapeString(string $string): string
    {
        return addslashes($string);
    }
}