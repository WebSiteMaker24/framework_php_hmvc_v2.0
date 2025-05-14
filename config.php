<?php

// Fonction pour charger les variables d'environnement depuis le fichier .env
function load_env($path) {
    if (!file_exists($path)) return;

    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (str_starts_with(trim($line), '#')) continue; // Ignorer les commentaires
        list($key, $value) = explode('=', $line, 2);
        putenv(trim($key) . '=' . trim($value));
    }
}

// Charger les variables d'environnement depuis le fichier .env
load_env(__DIR__ . '/../.env');