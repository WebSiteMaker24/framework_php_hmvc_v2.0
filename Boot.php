<?php

class Boot {

    public $_route;

    public function __construct() {
        $this->_route = __DIR__;
    }

    public function run() {
        // Chargement du controleur principal
        require_once $this->getRoute() . "/src/control/ControlMain.php";
        $controlMain = new ControlMain($this);
        // Chargement des class nécessaires
        $controlMain->loadControl();
        Middleware::middleware();
        $csrfProtection = new CSRFProtection();
        $csrfProtection->generateToken();


        // 🟧 Gestion dynamique des formulaires
        $form = isset($_POST["action"]) ? $_POST["action"] : null;

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Vérifie si le token CSRF est valide avant de traiter le formulaire
            if (!isset($_POST['csrf_token']) || !$csrfProtection->validateToken($_POST['csrf_token'])) {
                $_SESSION["message"] = "Erreur : Token CSRF invalide !"; // Gérer l'erreur de manière appropriée

                // Enregistrement de l'erreur dans le fichier de log
                $log = "[" . date("Y-m-d H:i:s") . "] Tentative CSRF - IP : " . $_SERVER['REMOTE_ADDR'] . "\n";
                error_log($log, 3, $this->getRoute() . "src/logs/security.log");
                // Redirection pour éviter l’exécution du code suivant
                header("Location: ?url=".$form); 
                exit;
            }
            $handlerform = new HandlerForm(); // Instanciation de la classe HandlerForm
            // Appel de la méthode appropriée en fonction de l'action du formulaire
            switch ($form) {
            case 'inscription':
                $handlerform->inscription(); // Gère l'inscription
            break;
            case 'connexion':
                $handlerform->connexion(); // Gère la connexion
            break;
            default:
                $_SESSION["message"] = "Erreur : Formulaire invalide !";
            break;
            }
        }

        // ✅ Gestion dynamique des vues
        $url = isset($_GET["url"]) ? $_GET["url"] : "accueil";

        // Liste des pages autorisées
        $routes_valides = ["accueil", "services", "contact", "inscription"];
        if (!in_array($url, $routes_valides)) {
            $url = (string) "404";
        }

        switch($url) {
            case "accueil" :
                $page = $this->getRoute() . "/src/view/navigation/accueil.php";
            break;

            case "services" :
                $page = $this->getRoute() . "/src/view/navigation/services.php";
            break;

            case "contact" :
                $page = $this->getRoute() . "/src/view/navigation/contact.php";
            break;

            case "inscription" :
                $page = $this->getRoute() . "/src/view/form/inscription.php";
            break;

            case "404" :
                $page = $this->getRoute() . "/src/view/navigation/404.php";
            break;

            default :
                $page = $this->getRoute() . "/src/view/navigation/accueil.php";
            break;
        }

        $route_css = "public_html/public/css/";
        
        require_once $this->getRoute() . "/src/view/template/header.php";
        require_once $this->getRoute() . "/src/view/template/navbar.php";
        require_once $page;
        require_once $this->getRoute() . "/src/view/template/footer.php";
    }

    public function getRoute() {
        return $this->_route;
    }
}