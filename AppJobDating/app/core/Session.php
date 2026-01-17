<?php

namespace App\core;

class Session
{
    private static $instance = null;

    private function __construct()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Récupère l'instance unique (Singleton)
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Définit une valeur en session
     */
    public function set(string $key, $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Récupère une valeur de la session
     */
    public function get(string $key, $default = null)
    {
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Vérifie si une clé existe
     */
    public function has(string $key): bool
    {
        return isset($_SESSION[$key]);
    }

    /**
     * Supprime une valeur de la session
     */
    public function delete(string $key): void
    {
        unset($_SESSION[$key]);
    }

    /**
     * Détruit toute la session
     */
    public function destroy(): void
    {
        session_destroy();
        $_SESSION = [];
    }

    /**
     * Flash message (message temporaire)
     */
    public function flash(string $key, $value = null)
    {
        if ($value === null) {
            $message = $this->get("flash_{$key}");
            $this->delete("flash_{$key}");
            return $message;
        }

        $this->set("flash_{$key}", $value);
    }

    /**
     * Régénère l'ID de session (sécurité)
     */
    public function regenerate(): void
    {
        session_regenerate_id(true);
    }

    /**
     * Récupère toutes les données de session
     */
    public function all(): array
    {
        return $_SESSION;
    }
}