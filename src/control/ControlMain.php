<?php

// Inclue Boot.php pour utiliser sa 
require_once __DIR__ . "/../../Boot.php";

class ControlMain {

    public $_route;
    
    public function __construct(?Boot $boot = null) {
        $this->_route = $boot ?? new Boot();
    }

    // 🟩 Charge les controleurs nécessaire
    public static function loadControl() {
        // Instancier la classe Boot
        $boot = new Boot();

        // Utiliser la méthode getRoute pour obtenir la route absolue
        $route = $boot->getRoute();

        // Inclusion des controleurs nécessaire
        require_once $route . "/src/control/ControlMain.php"; 
        require_once $route . "/src/csrf/CSRFProtection.php";  
        require_once $route . "/src/middleware/Middleware.php";  
    }

    // 🧡 Gestion des messages flash
    public static function message_flash() {
        if (isset($_SESSION["message"])) {
            $message = $_SESSION["message"];
            unset($_SESSION["message"]);
            return $message;
        } else {
            return null;
        }
    }

    // 🟡 Affiche la template dynamiquement (marche pas celle la xd)
    public static function displayTemplate($page) {
        require_once $this->getRoute() . "/src/view/template/header.php";
        require_once $this->getRoute() . "/src/view/template/navbar.php";
        require_once $page;
        require_once $this->getRoute() . "/src/view/template/footer.php";
    }

    // 💙 Charge la route absolue depuis la racine du fichier boot.php
    public function getRoute() {
        return $this->_route;
    }
}