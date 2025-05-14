<?php

class CSRFProtection {
    // Génération d'un token CSRF unique et stockage dans la session
    public function generateToken() {
        if (session_status() == PHP_SESSION_NONE) {
            // 1. Options de sécurité pour la session
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // true seulement en HTTPS
            ini_set('session.use_only_cookies', 1);
        }

        if (empty($_SESSION['csrf_token'])) {
            // Génère un token unique et sécurisé
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32)); // 32 octets pour un token assez long
        }
    }

    // Inclure le token dans un formulaire HTML
    public function includeToken() {
        echo '<input type="hidden" name="csrf_token" value="' . $_SESSION['csrf_token'] . '">';
    }

    // Vérification du token à la soumission du formulaire
    public function validateToken($token) {
        if (session_status() == PHP_SESSION_NONE) {
            // 1. Options de sécurité pour la session
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // true seulement en HTTPS
            ini_set('session.use_only_cookies', 1);
        }

        if (isset($_SESSION['csrf_token']) && $token === $_SESSION['csrf_token']) {
            // Le token est valide
            return true;
        }

        // Le token est invalide
        return false;
    }

    // Nettoyage du token après soumission du formulaire pour plus de sécurité
    public function cleanupToken() {
        if (session_status() == PHP_SESSION_NONE) {
            // 1. Options de sécurité pour la session
            ini_set('session.use_strict_mode', 1);
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS'])); // true seulement en HTTPS
            ini_set('session.use_only_cookies', 1);
        }

        unset($_SESSION['csrf_token']);
    }
}