<?php

require_once __DIR__ .  "/../../config.php";

$db_host = getenv('DB_HOST');
$db_user = getenv('DB_USER');
$db_pass = getenv('DB_PASS');
$db_name = getenv('DB_NAME');

class Base
{
    private static $_pdo = null; // Connexion PDO statique

    // Constructeur qui établit la connexion à la base de données
    public function __construct()
    {
        if (self::$_pdo === null) { // Si la connexion n'existe pas déjà
            try {
                self::$_pdo = new PDO(
                    "mysql:host=" . $this->getHost() . ";dbname=" . $this->getDbName() . ";charset=utf8",
                    $this->getUser(),
                    $this->getPass(),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die("❌ Erreur de connexion : " . $e->getMessage());
            }
        }
    }

    // Getter pour l'hôte de la base de données
    public function getHost()
    {
        return getenv('DB_HOST');
    }

    // Getter pour l'utilisateur de la base de données
    public function getUser()
    {
        return getenv('DB_USER');
    }

    // Getter pour le mot de passe de la base de données
    public function getPass()
    {
        return getenv('DB_PASS');
    }

    // Getter pour le nom de la base de données
    public function getDbName()
    {
        return getenv('DB_NAME');
    }

    // Retourne la connexion PDO
    public function getPdo()
    {
        return self::$_pdo;
    }
}